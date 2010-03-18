<?php
class Subscription extends AppModel
{
	public $name = 'Subscription';
	
	public $virualFields = array(
		'subscription' => 'CONCAT(Event.alias, " - ", User.username)'
	);
	
	public $displayField = 'subscription';

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