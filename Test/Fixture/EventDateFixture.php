<?php
/**
 * EventDateFixture
 *
 */
class EventDateFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'event_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'desc' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'event_id' => 1,
			'date' => '2013-10-05 20:10:51',
			'desc' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-07-17 20:10:51',
			'modified' => '2013-07-17 20:10:51',
			'created_by' => 1,
			'modified_by' => 1
		),
		array(
			'id' => 2,
			'event_id' => 2,
			'date' => '2013-01-05 20:10:51',
			'desc' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-07-17 20:10:51',
			'modified' => '2013-07-17 20:10:51',
			'created_by' => 1,
			'modified_by' => 1
		),
		array(
			'id' => 3,
			'event_id' => 3,
			'date' => '2013-01-05 20:10:51',
			'desc' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-07-17 20:10:51',
			'modified' => '2013-07-17 20:10:51',
			'created_by' => 1,
			'modified_by' => 1
		),
		array(
			'id' => 4,
			'event_id' => 4,
			'date' => '',
			'desc' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-07-17 20:10:51',
			'modified' => '2013-07-17 20:10:51',
			'created_by' => 1,
			'modified_by' => 1
		),
	);

}
