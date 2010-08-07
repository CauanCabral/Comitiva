<?php
/**
 * AlterUsers Migration
 *
 * @since 08/06/2010 19:14:47
 */
class AlterUsers extends AppMigration {

/**
 * Up Method
 *
 * @return void
 * @access public
 */
	function up()
	{
		// atualizando o campo com os tipo do usário para permitir mais de um tipo
		$this->changeColumn(
			'users',
			'type',
			array(
				'name' => 'groups',
				'length' => 255,
				'default' => json_encode(array('participant'))
			),
			 true
		);
		
		// alterando o valor do campo nos registros para equivalente na notação json
		$model = $this->getModel('users');
		
		$users = $model->find('all');
		
		$this->out(__('Atualizando registros...', true), false);
		foreach($users as $user)
		{
			$user['User']['groups'] = json_encode(array($user['User']['groups']));
			
			if(!$model->save($user))
			{
				trigger_error('Falha ao atualizar campo type do modelo usuário', E_USER_ERROR);
			}
		}
		$this->out(__('ok', true), true);
	}

/**
 * Down Method
 *
 * @return void
 * @access public
 */
	function down()
	{
		$model = $this->getModel('users');
		
		$users = $model->find('all');
		
		$this->out(__('Atualizando registros...', true), false);
		foreach($users as $user)
		{
			$type = json_decode($user['User']['groups'], true);
			$user['User']['groups'] = $type[0];
			
			if(!$model->save($user))
			{
				trigger_error('Falha ao desatualizar campo type do modelo usuário', E_USER_ERROR);
			}
		}
		$this->out(__('ok', true), true);
		
		$this->changeColumn(
			'users',
			'groups',
			array(
				'name' => 'type',
				'length' => 30,
				'default' => 'participant'
			)
		);
	}
}

?>