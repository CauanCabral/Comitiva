<?php
class Payment extends AppModel {
	var $name = 'Payment';
	var $displayField = 'id';
	var $validate = array(
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
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Subscription' => array(
			'className' => 'Subscription',
			'foreignKey' => 'subscription_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>