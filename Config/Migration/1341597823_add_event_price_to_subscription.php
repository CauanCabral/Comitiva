<?php
class AddEventPriceToSubscription extends CakeMigration {

	/**
	 * Migration description
	 *
	 * @var string
	 * @access public
	 */
	public $description = '';

	/**
	 * Actions to be performed
	 *
	 * @var array $migration
	 * @access public
	 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'subscriptions' => array(
					'event_price_id' => array('type' => 'integer', 'null' => false, 'after' => 'event_id')
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'subscriptions' => array('event_price_id')
			)
		),
	);
}
