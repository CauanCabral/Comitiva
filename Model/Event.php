<?php
class Event extends AppModel
{
	public $name = 'Event';

	public $displayField = 'title';

	public $actsAs = array('Locale.Locale');

	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Obrigatório'
			)
		),
		'alias' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Obrigatório'
			)
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Obrigatório'
			)
		),
	);

	public $belongsTo = array(
		'ParentEvent' => array(
			'className' => 'Event',
			'foreignKey' => 'parent_id'
		)
	);

	public $hasMany = array(
		'EventDate' => array(
			'className' => 'EventDate',
			'foreignKey' => 'event_id',
			'dependent' => true,
			'order' => 'EventDate.date ASC'
		),
		'EventPrice' => array(
			'className' => 'EventPrice',
			'foreignKey' => 'event_id',
			'dependent' => true,
			'order' => 'EventPrice.final_date ASC'
		),
		'ChildEvent' => array(
			'className' => 'Event',
			'foreignKey' => 'parent_id',
			'dependent' => true
		),
		'Subscription' => array(
			'className' => 'Subscription',
			'foreignKey' => 'event_id',
			'dependent' => false
		)
	);

	/**
	 * Inclui ou atualiza um registro de evento.
	 *
	 * @param array $event Dados do evento
	 * @return bool
	 */
	public function add($event = null)
	{
		if($event === null)
			return false;

		if(!isset($event['Event']['alias']))
			$event['Event']['alias'] = Inflector::slug(mb_strtolower($event['Event']['title']), '-');

		if(empty($event['EventDate']))
			unset($event['EventDate']);

		if(empty($event['EventPrice']))
			unset($event['EventPrice']);

		if(isset($event['EventDate']))
		{
			foreach($event['EventDate'] as &$dates)
			{
				if(!empty($dates['time']))
					$dates['date'] = $dates['date'] . ' ' . $dates['time'];
			}
		}

		if($this->saveAssociated($event))
			return true;

		return false;
	}

	/**
	 * Método auxiliar para recuperar lista com eventos (sub-eventos não são listados)
	 *
	 * @param array $conditions
	 * @return array - lista de usuários (equivalente a User::find('list'))
	 */
	public function getList($conditions = array())
	{
		$defaultCondition = array('OR' => array('Event.parent_id IS NULL', 'Event.parent_id' => 0));

		$conditions = array_merge($defaultCondition, $conditions);

		$this->contain();
		return $this->find('list', array('conditions' => $conditions));
	}

	public function getOpenToSubscriptionList($conditions = array())
	{
		$all = $this->getList();
		$opens = array();

		foreach($all as $event => $title)
		{
			if($this->openToSubscription($event))
				$opens[$event] = $title;
		}

		return $opens;
	}

	/**
	 * Retorna a situação de um evento em relação a inscrição de novos participantes.
	 *
	 * Por padrão  um evento está aberto para inscrição até o dia anterior
	 * ao seu último dia de realização. Ou seja, um participante pode se inscrever
	 * durante o evento, desde que não seja no último dia.
	 *
	 * Outra condição necessária para o evento estar aberto é o campo 'open' ter
	 * valor 1 (true). Caso contrário o evento estará fechado, com prioridade
	 * sobre o critério anterior.
	 *
	 * @param int $id
	 * @param array $eventData Dados de um read ou find('first') no modelo Evento
	 * @return bool $open
	 */
	public function openToSubscription($id, $eventData = null)
	{
		if($eventData == null && !empty($this->data) && $this->id == $id)
			$eventData = $this->data;

		if($eventData == null)
		{
			$this->contain();
			$this->id = $id;
			$eventData = $this->read('open');
		}

		if($eventData['Event']['open'] == false)
			return false;

		$today = date('Y-m-d');
		$end = $this->getLastDay($id);

		$isOpen = ($today < $end);

		// atualiza o evento como fechado para futuras consultas
		if(!$isOpen)
		{
			$this->create();
			$this->id = $id;
			$this->saveField('open', 0);
		}

		return $isOpen;
	}

	/**
	 * Retorna o primeiro dia do evento, se houver data
	 *
	 * @param int $id ID do Evento
	 * @return mixed null se o evento não possuir data definida
	 * ou a data do primeiro dia caso existam datas
	 */
	public function getFirstDay($id)
	{
		$event_dates = $this->EventDate->find('first', array(
			'conditions' => array('event_id' => $id),
			'contain' => array(),
			'order' => array('date' => 'asc')
		));

		if(empty($event_dates))
			return null;

		return $event_dates['EventDate']['date'];
	}

	/**
	 * Retorna o último dia do evento, se houver data
	 *
	 * @param int $id ID do Evento
	 * @return mixed null se o evento não possuir data definida
	 * ou a data do último dia caso existam datas
	 */
	public function getLastDay($id)
	{
		$event_dates = $this->EventDate->find('first', array(
			'conditions' => array('event_id' => $id),
			'contain' => array(),
			'order' => array('date' => 'desc')
		));

		if(empty($event_dates))
			return null;

		return $event_dates['EventDate']['date'];
	}
}