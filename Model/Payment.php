<?php
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
     * @param string $type
     * @param array $data
     * @return bool
     */
    public function receive($data, $notificationCode = null)
    {
        if(!isset($data['code']))
            return false;

        $this->begin();

        if(!$this->update($data, $notificationCode)) {
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
     * @param string $type
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
        // Recupera a mensagem do estado do pagamento
        $status = $this->StatusMessage->read('name', $data['status_code']);
        $data['status_msg'] = $status['StatusMessage']['name'];

        $check = $this->find('first', array(
            'conditions' => array(
                'Payment.transaction_code' => $data['code'],
                'Event.id' => $data['reference']
            	),
            'contain' => array('Event')
            )
        );

        // é uma atualização
        if($check) {
            $data['id'] = $check['Payment']['id'];
        }

        $this->create();
        if(!$this->save($data)) {
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