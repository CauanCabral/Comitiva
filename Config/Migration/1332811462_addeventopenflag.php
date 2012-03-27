<?php
class AddEventOpenFlag extends CakeMigration {

	public $description = '';

	public $migration = array(
		'up' => array(
			'create_field' => array(
				'events' => array(
					'open' => array('type' => 'boolean', 'default' => true, 'null' => false, 'after' => 'id'),
				)
			)
		),
		'down' => array(
			'drop_field' => array(
				'events' => array('open')
			)
		),
	);
}
