<?php
class EventDate extends AppModel {
	var $name = 'EventDate';
	var $validate = array(
		'date' => array(
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