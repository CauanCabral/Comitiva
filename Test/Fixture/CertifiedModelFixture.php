<?php
/**
 * CertifiedModelFixture
 *
 */
class CertifiedModelFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'image' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 256, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'image_dir' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'title' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'image' => 'Lorem ipsum dolor sit amet',
			'image_dir' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-07-17 17:42:59',
			'modified' => '2013-07-17 17:42:59'
		),
	);

}
