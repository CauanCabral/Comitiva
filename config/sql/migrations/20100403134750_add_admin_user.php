<?php
/**
 * AddAdminUser Migration
 *
 * @since 04/03/2010 13:47:50
 */

 App::import('Core', array('Security'), false);

class AddAdminUser extends AppMigration {

	var $uses = array('User');

/**
 * Up Method
 *
 * @return void
 * @access public
 */
	function up() {
		$user['User'] = array('username' => 'admin',
								'password' => Security::hash('admin', null, true),
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
		
		if(!$this -> User -> save($user)) {
			var_dump($this -> User -> validationErrors);
		}
	}

/**
 * Down Method
 *
 * @return void
 * @access public
 */
	function down() {
		$u = $this -> User -> findByUsername('admin');
		$this -> User -> delete($u['User']['id']);
	}
}

?>