<?php
class EventPrice extends AppModel
{
	public $name = 'EventPrice';
	
	public $actsAs = array(
		'Locale.Locale'
	);
	
	public $validate = array(
		'price' => array(
			'numeric' => array('rule' => array('numeric')),
		),
		'start_date' => array(
			'date' => array('rule' => array('date')),
		),
		'final_date' => array(
			'date' => array('rule' => array('date')),
		),
	);

	public $belongsTo = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_id'
		)
	);
}
?>