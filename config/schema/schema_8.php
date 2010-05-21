<?php 
/* SVN FILE: $Id$ */
/* Comitiva schema generated on: 2010-05-21 13:05:38 : 1274463698*/
class ComitivaSchema extends CakeSchema {
	var $name = 'Comitiva';

	var $file = 'schema_8.php';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $event_dates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'event_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'desc' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $event_prices = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'event_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'observation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'price' => array('type' => 'float', 'null' => false, 'default' => NULL),
		'start_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'final_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $events = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'alias' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'free' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'subscription_count' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $payments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'subscription_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'amount' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '6,2'),
		'information' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'confirmed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $subscriptions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'event_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'checked' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45),
		'nickname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'birthday' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'token' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'token_expires_at' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => false, 'default' => 'participant', 'length' => 30),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'last_access' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'account_validation_token' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'account_validation_expires_at' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'cpf' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 14),
		'address' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40),
		'state' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2),
		'phone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 15),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
}
?>