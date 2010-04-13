<?php
class Event extends AppModel
{
	public $name = 'Event';
	
	public $displayField = 'title';
	
	public $validate = array(
		'title' => array(
			'notempty' => array('rule' => array('notempty'))
		),
		'alias' => array(
			'notempty' => array('rule' => array('notempty'))
		),
		'description' => array(
			'notempty' => array('rule' => array('notempty'))
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
			'dependent' => true
		),
		'EventPrice' => array(
			'className' => 'EventPrice',
			'foreignKey' => 'event_id',
			'dependent' => true
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

	public function add($event = null)
	{
		if($event === null)
		{
			return FALSE;
		}
		
		if(!isset($event['Event']['alias']))
		{
			$event['Event']['alias'] = Inflector::slug(mb_strtolower($event['Event']['title']), '-');
		}
		
		if(empty($event['EventDate']))
			unset($event['EventDate']);
			
		if(empty($event['EventPrice']))
			unset($event['EventPrice']);
		
		// init transaction
		$this->begin();
		
		if($this->saveAll($event, array('validate' => 'first')))
		{
			// save database changes
			$this->commit();
			return TRUE;
		}
		
		// has an error
		$this->rollback();
		return FALSE;
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
		
		return $this->find('list', array('conditions' => $conditions));
	}
}
?>