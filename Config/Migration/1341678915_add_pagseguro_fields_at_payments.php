<?php
class AddPagseguroFieldsAtPayments extends CakeMigration {

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
				'payments' => array(
					'transaction_code' => array('type' => 'string', 'length' => '36', 'null' => true, 'default' => null),
					'status' => array('type' => 'integer', 'length' => 2, 'null' => true, 'default' => null)
				)
			)
		),
		'down' => array(
			'drop_field' => array(
				'payments' => array('transaction_code', 'status')
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
