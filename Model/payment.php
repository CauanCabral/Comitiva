<?php
class Payment extends AppModel
{
	public $name = 'Payment';
	
	public $displayField = 'date';
	
	public $actsAs = array(
		'Locale.Locale'
	);
	
	public $validate = array(
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

	public $belongsTo = array(
		'Subscription' => array(
			'className' => 'Subscription',
			'foreignKey' => 'subscription_id',
			'dependent' => true
		)
	);
}
?>