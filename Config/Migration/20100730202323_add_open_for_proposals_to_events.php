<?php
/**
 * AddOpenForProposalsToEvents Migration
 *
 * @since 07/30/2010 20:23:23
 */
class AddOpenForProposalsToEvents extends CakeMigration
{
	public $migration = array(
			'up' => array(
					'create_field' => array(
							'events' => array(
								'open_for_proposals' => array('type' => 'integer', 'length' => 1)
								)
						)
				),
			'down' => array(
					'drop_field' => array(
							'events' => array('open_for_proposals')
						)
				)
		);
}