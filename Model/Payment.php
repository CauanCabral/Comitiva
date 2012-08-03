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
                'Payment.transaction_code' => $data['code'],
                'Subscription.id' => $data['reference']
            	),
            'contain' => array('Subscription')
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

    public function toDisplay($id)
    {
        $this->contain();
        $data = $this->read(null, $id);

        return "PagSeguro ( {$data['Payment']['transaction_code']} )";
    }
}