<?php
/**
 * CreateProposals Migration
 *
 * @since 07/30/2010 19:37:48
 */
class CreateProposals extends CakeMigration
{
	public $migration = array(
			'up' => array(
					'create_table' => array(
							'proposals' => array(
								'user_id' => array('type' => 'integer', 'null' => false),
								'event_id' => array('type' => 'integer', 'null' => false),
								'mini_curriculum' => array('type' => 'string', 'length' => 512, 'null' => false),
								'area' => array('type' => 'string', 'length' => 64, 'null' => true),
								'abstract' => array('type' => 'string', 'length' => 512, 'null' => false),
								'detailed' => array('type' => 'string', 'length' => 2048, 'null' => false)
								)
						)
				),
			'down' => array(
					'drop_table' => array(
							'proposals'
						)
				)
		);
}