<?php
class M4bada3ee07ec467a8fca03ef7f000002 extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	var $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	var $migration = array(
		'up' => array(
			'create_field' => array(
				'event_dates' => array(
					'desc' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
				),
				'event_prices' => array(
					'observation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40),
				),
			),
			'alter_field' => array(
				'event_dates' => array(
					'date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
				),
			),
			'drop_table' => array(
				'events', 'payments', 'subscriptions', 'users'
			),
		),
		'down' => array(
			'drop_field' => array(
				'event_dates' => array('desc',),
				'event_prices' => array('observation',),
			),
			'alter_field' => array(
				'event_dates' => array(
					'date' => array('type' => 'date', 'null' => false, 'default' => NULL),
				),
			),
			'create_table' => array(
				'events' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
					'alias' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'free' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
					'subscription_count' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'payments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'subscription_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'date' => array('type' => 'date', 'null' => false, 'default' => NULL),
					'amount' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '6,2'),
					'information' => array('type' => 'string', 'null' => true, 'default' => NULL),
					'confirmed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'subscriptions' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'event_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
					'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
					'email' => array('type' => 'string', 'null' => false, 'default' => NULL),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
					'nickname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
					'birthday' => array('type' => 'date', 'null' => false, 'default' => NULL),
					'token' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40),
					'token_expires_at' => array('type' => 'date', 'null' => true, 'default' => NULL),
					'last_access' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	function after($direction) {
		return true;
	}
}
?>