<?php
class AddAwardsTable extends CakeMigration {

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
			'create_table' => array(
				'awards' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'title' => array('type' => 'string', 'length' => 150, 'null' => false, 'default' => NULL, 'after' => 'id'),
					'description' => array('type' => 'text',  'null' => true, 'default' => NULL, 'after' => 'title'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'user_id'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'created'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					)
				),
			),
			'create_field' => array(
				'raffles' => array(
					'award_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'token_expires_at'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'awards'
			),
			'drop_field' => array(
				'raffles' => array('award_id'),
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
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
