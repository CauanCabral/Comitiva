<?php
/* Proposal Fixture generated on: 2010-07-30 19:07:34 : 1280533474 */
class ProposalFixture extends CakeTestFixture {
	var $name = 'Proposal';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'mini_curriculum' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 512),
		'area' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64),
		'abstract' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 512),
		'detailed' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2048),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'mini_curriculum' => 'Lorem ipsum dolor sit amet',
			'area' => 'Lorem ipsum dolor sit amet',
			'abstract' => 'Lorem ipsum dolor sit amet',
			'detailed' => 'Lorem ipsum dolor sit amet',
			'created' => '2010-07-30 19:44:34',
			'modified' => '2010-07-30 19:44:34'
		),
	);
}
?>