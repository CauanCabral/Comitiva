<?php
/**
 * SubscriptionFixture
 *
 */
class SubscriptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'event_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'event_price_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'checked' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created_by' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified_by' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'event_id' => 1,
			'event_price_id' => 1,
			'checked' => 1,
			'created' => '2013-07-17 20:11:57',
			'modified' => '2013-07-17 20:11:57',
			'created_by' => 1,
			'modified_by' => 1
		),
	);

}
