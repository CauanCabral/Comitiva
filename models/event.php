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
			'foreignKey' => 'parent_id',
			'conditions' => array('Event.parent_id IS NOT NULL'),
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

}
?>