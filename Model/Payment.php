<?php
App::uses('AppModel', 'Model');
class Payment extends AppModel
{
	public $name = 'Payment';

	public $displayField = 'date';

	public $actsAs = array(
		'Locale.Locale'
	);

	public $validate = array(
		'date' => array(
			'date' => array('rule' => array('date')),
		),
		'amount' => array(
			'notempty' => array('rule' => array('notempty')),
		),
		'information' => array(
			'notempty' => array('rule' => array('notempty')),
		),
	);

	public $belongsTo = array(
		'Subscription' => array(
			'className' => 'Subscription',
			'foreignKey' => 'subscription_id',
			'dependent' => true
		)
	);

	/**
     * Recebe notificação de pagamentos a partir de diversas fontes
     * (no momento com suporte apenas ao PagSeguro),
     *
     * @param array $data
     * @return bool
     */
    public function receive($data)
    {
        if(!isset($data['code']))
            return false;

        $this->begin();

        if(!$this->update($data)) {
            $this->rollback();
            return false;
        }

        $this->commit();
        return true;
    }

    /**
     * Atualização a situação do pagamentos a partir de diversas fontes
     * (no momento com suporte apenas ao PagSeguro),
     *
     * @param array $data
     * @return boolean
     */
    public function updateSituations($data)
    {
        if(!isset($data['items'])) {
            return false;
        }

        $this->begin();

        foreach($data['items'] as $transaction) {

            if(!$this->update($transaction)) {
                $this->rollback();

                return false;
            }
        }

        $this->commit();
        return true;
    }

    /**
     * Atualiza ou cria um registro de pagamento
     *
     * @param array $data
     * @return boolean
     */
    public function update($data)
    {
        $toSave = array(
            'subscription_id' => $data['reference'],
            'transaction_code' => $data['code'],
            'status' => $data['status'],
            'confirmed' => ($data['status'] == 3 || $data['status'] == 4) ? true : false,
            'information' => 'Pagamento via PagSeguro',
            'date' => substr($data['date'], 0, 10),
            'amount' => $data['grossAmount']
        );

        $check = $this->find('first', array(
            'conditions' => array(
                'subscription_id' => $data['reference']
            	),
            'contain' => array()
            )
        );

        // é uma atualização
        if($check) {
            $toSave['id'] = $check['Payment']['id'];
        }

        $this->create();
        if(!$this->save($toSave)) {
            return false;
        }

        return true;
    }

    public function fixDuplicates()
    {
        $payments = $this->find('all', array('contain' => array()));

        $bogus = array();
        $counter = array();
        $repeateds = array();

        foreach($payments as $payment) {
            if(!isset($repeateds[$payment['Payment']['subscription_id']])) {
                $repeateds[$payment['Payment']['subscription_id']] = array();
                $counter[$payment['Payment']['subscription_id']] = 0;
            }

            $counter[$payment['Payment']['subscription_id']]++;
            $repeateds[$payment['Payment']['subscription_id']][$payment['Payment']['id']] = $payment['Payment'];
        }

        foreach($repeateds as $sub => $repeated) {
            $aux = null;
            if($counter[$sub] == 1) {
                unset($repeateds[$sub]);
                continue;
            }

            foreach($repeated as $key => $payment) {
                if($aux === null) {
                    $aux = $payment;
                    continue;
                }

                if($payment['confirmed'] == false && $aux['confirmed'] == true) {
                    $bogus[$payment['id']] = $payment['id'];
                    continue;
                }

                if($payment['modified'] > $aux['modified']) {
                    $bogus[$aux['id']] = $aux['id'];
                    $aux = $payment;
                }
            }
        }

        if(!empty($bogus)) {
            return $this->deleteAll(array('Payment.id' => $bogus));
        }

        return true;
    }

    public function toDisplay($id)
    {
        $this->contain();
        $data = $this->read(null, $id);

        return "PagSeguro ( {$data['Payment']['transaction_code']} )";
    }
}