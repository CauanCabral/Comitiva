<?php
class Subscription extends AppModel
{
	public $name = 'Subscription';

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_id',
			'counterCache' => true
		)
	);

	public $hasOne = array(
		'Payment' => array(
			'className' => 'Payment',
			'foreignKey' => 'subscription_id'
		)
	);

}
?>