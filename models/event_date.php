<?php
class EventDate extends AppModel
{
	public $name = 'EventDate';
	
	public $validate = array(
		'date' => array(
			'date' => array('rule' => array('date')),
		),
	);

	public $belongsTo = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>