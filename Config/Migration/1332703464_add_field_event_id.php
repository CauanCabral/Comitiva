<?php
class AddFieldEventId extends CakeMigration {

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
				'awards' => array(
					'event_id' => array('type' => 'integer', 'null' => false, 'after' => 'modified'),
					'groups' => array('type' => 'string', 'length' => 255)
				),
			),
		),
		'down' => array(
			'drop_field' => array('awards' => array('event_id', 'groups'))
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
