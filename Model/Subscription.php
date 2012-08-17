<?php
class Subscription extends AppModel
{
	public $name = 'Subscription';

	public $validate = array(
		'user_id' => array(
			'required' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, preencha o nome de usuário',
				'required' => true
			)
		),
		'event_id' => array(
			'required' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, selecione o evento',
				'required' => true
			)
		),
	);

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_id',
			'counterCache' => true
		),
		'EventPrice'
	);

	public $hasOne = array(
		'Payment' => array(
			'className' => 'Payment',
			'foreignKey' => 'subscription_id',
			'dependent' => true
		)
	);

	public $actsAs = array(
		'Search.Searchable',
		'Locale.Locale'
	);

	public $filterArgs = array(
		array('name' => 'query', 'type' => 'query', 'method' => 'searchFields')
	);

	/**
	 * Prepara os dados para o PagSeguro
	 *
	 * @param  array $event
	 * @param  array $participant
	 * @param  int   $price_id
	 * @return
	 */
	public function buildPaymentParams($event, $participant, $price_id)
	{
		if(empty($this->id))
			return false;

		$price = $this->EventPrice->find('first', array('conditions' => array('EventPrice.id' => $price_id), 'contain' => array()));

		$item = array(
			'reference' => $this->id,
			'sender' => array(
				'senderName' => $participant['name'],
				'senderEmail' => $participant['email'],
			),
			'item' => array(
				'id' => $this->id,
				'description' => "Inscrição no evento {$event['title']}",
				'amount' => $price['EventPrice']['price'],
				'quantity' => 1
			),
			'total' => $price['EventPrice']['price']
		);

		return $item;
	}

	/**
	 * Recebe o id de um evento e retorna todos os usuários
	 * que não estão inscritos neste evento
	 */
	public function getAllUnlisted($event_id = null)
	{
		// busco primeiro todos os usuários inscritos no evento
		$this->contain();
		$listeds = $this->find(
			'all',
			array(
				'conditions' => array('Subscription.event_id' => $event_id),
				'fields' => array('Subscription.user_id')
			)
		);

		// 'limpo' o array para passar como parametro na query seguinte
		$aux;
		foreach($listeds as $listed)
		{
			$aux[] = $listed['Subscription']['user_id'];
		}

		$this->User->contain();

		$unlisteds = $this->User->find(
			'all',
			array(
				'conditions' => array(
					'NOT' => array(
						'User.id' => $aux
					)
				)
			)
		);

		return $unlisteds;
	}

	/**
	 * Implementa busca via plugin Search
	 *
	 * @param array $data Valores para buscar
	 * @return array $conditions Condições da busca
	 */
	public function searchFields($data = array())
	{
		$filter = $data['query'];

		$conditions = array(
			'OR' => array(
				'Event.title LIKE' => '%' . $filter . '%',
				'User.name LIKE' => '%' . $filter . '%',
				'User.username' => $filter,
				'User.cpf' => $filter
			)
		);

		return $conditions;
	}

	public function fixDuplicates() {
		$subscriptions = $this->find('all', array('contain' => array()));

		$bogus = array();
        $counter = array();
        $repeateds = array();

        foreach($subscriptions as $subscription) {
        	$index = $subscription['Subscription']['event_id'] . $subscription['Subscription']['user_id'] . $subscription['Subscription']['event_price_id'];

            if(!isset($repeateds[$index])) {
                $repeateds[$index] = array();
                $counter[$index] = 0;
            }

            $counter[$index]++;
            $repeateds[$index][$subscription['Subscription']['id']] = $subscription['Subscription'];
        }

        foreach($repeateds as $sub => $repeated) {
            $aux = null;
            if($counter[$sub] == 1) {
                unset($repeateds[$sub]);
                continue;
            }

            foreach($repeated as $key => $subscription) {
            	pr($subscription);
                if($aux === null) {
                    $aux = $subscription;
                    continue;
                }

                $paymentA = $this->Payment->find('first', array('conditions' => array('subscription_id' => $aux['id']), 'contain' => array()));
                $paymentB = $this->Payment->find('first', array('conditions' => array('subscription_id' => $subscription['id']), 'contain' => array()));

                if($paymentA['Payment']['confirmed'] == true && $paymentB['Payment']['confirmed'] == false) {
                    $bogus[$subscription['id']] = $subscription['id'];
                    continue;
                }

                if($subscription['created'] >= $aux['created']) {
                    $bogus[$aux['id']] = $aux['id'];
                    $aux = $subscription;
                }
            }
        }

        if(!empty($bogus)) {
            return $this->deleteAll(array('Subscription.id' => $bogus));
        }

        return true;
	}
}