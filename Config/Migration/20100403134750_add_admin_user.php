<?php
/**
 * AddAdminUser Migration
 *
 * @since 04/03/2010 13:47:50
 */

 App::uses('Security', 'Utility');

class AddAdminUser extends CakeMigration
{

	public $migration = array(
			'up' => array(
				),
			'down' => array(
				)
		);

	public function after($direction)
	{
		if($direction !== 'up')
		{
			return true;
		}

		$user['User'] = array('username' => 'admin',
			'password' => Security::hash('admin', null, true),
			'type' => 'admin',
			'email' => 'admin@example.com',
			'name' => 'Admin',
			'nickname' => 'admin',
			'birthday' => '1970-04-07',
			'active' => 1,
			'cpf' => '000.000.000-00',
			'address' => 'R. do Admin',
			'city' => '',
			'state' => '',
			'phone' => ''
		);

		$User = $this->generateModel('User');

		if(!$User->save($user))
		{
			pr($User->validationErrors);
		}

		return true;
	}
}