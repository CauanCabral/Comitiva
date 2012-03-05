<?php
/**
 * Proposals Migration
 *
 * @since 08/01/2010 21:06:28
 */
class Proposals extends CakeMigration
{
	public $migration = array(
			'up' =>  array(
					'create_field' => array(
							'proposals' => array(
									'approved' => array('type' => 'boolean'),
									'rating' => array('type' => 'integer'),
									'avaliator' => array('type' => 'string', 'length' => 45)
								)
						)
				),
			'down' => array(
					'drop_field' => array(
							'proposals' => array('approved', 'rating', 'avaliator')
						)
				)
		);
}
