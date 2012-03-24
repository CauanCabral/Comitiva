<?php
class RafflesTable extends CakeMigration {

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
				'raffles' => array(
					'id' => array('type' => 'integer', 'null' => false, 'key' => 'primary', 'autoincrement'=> true),
					'user_id' => array('type' => 'integer', 'null' => false),
					'award_id' => array('type' => 'integer', 'null' => false),
					'created' => array('type' => 'datetime'),
					'modified' => array('type' => 'datetime')
				)
			)
		),
		'down' => array(
			'drop_table' => array(
				'raffles'
			)
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
