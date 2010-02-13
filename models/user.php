<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'name';
	var $validate = array(
		'username' => array(
			'notempty' => array('rule' => array('notempty')),
			'alphanumeric' => array('rule' => array('alphanumeric')),
		),
		'email' => array(
			'email' => array('rule' => array('email')),
			'notempty' => array('rule' => array('notempty')),
		),
		'name' => array(
			'notempty' => array('rule' => array('notempty')),
		),
		'nickname' => array(
			'notempty' => array('rule' => array('notempty')),
		),
		'birthday' => array(
			'date' => array('rule' => array('date')),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Subscription' => array(
			'className' => 'Subscription',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>