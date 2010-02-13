<?php
class EventPrice extends AppModel {
	var $name = 'EventPrice';
	var $validate = array(
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
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
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