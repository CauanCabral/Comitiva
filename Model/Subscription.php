<?php
class Subscription extends AppModel
{
	public $name = 'Subscription';

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_id',
			'counterCache' => true
		)
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
}