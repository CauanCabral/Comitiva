<?php
class AddTableCertifiedModels extends CakeMigration {

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
				'certified_models' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4', 'after' => 'id'),
					'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 512, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4', 'after' => 'title'),
					'image' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 256, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4', 'after' => 'description'),
					'image_dir' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4', 'after' => 'image'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'after' => 'image_dir'),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'after' => 'created'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'create_field' => array(
				'events' => array(
					'certified_model_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'open_for_proposals'),
					'certified_description' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'certified_model_id'),
					'certified_position' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 12, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'certified_description'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'certified_models'
			),
			'drop_field' => array(
				'events' => array('certified_model_id', 'certified_description', 'certified_position',),
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
