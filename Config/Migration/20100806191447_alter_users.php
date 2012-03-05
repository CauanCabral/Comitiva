<?php
/**
 * AlterUsers Migration
 *
 * @since 08/06/2010 19:14:47
 */
class AlterUsers extends CakeMigration
{
	public $migration = array(
			'up' => array(
					'alter_field' => array(
							'users' => array(
								'type' => array(
									'name' => 'groups',
									'length' => 255,
									'default' => '["participant"]'
								)
							)
						)
				),
			'down' => array(
					'alter_field' => array(
							'users' => array(
								'groups' => array(
									'name' => 'type',
									'length' => 30,
									'default' => 'participant'
								)
							)
						)
				)
		);

	public function before($direction)
	{
		if($direction === 'down')
		{
			$model = $this->generateModel('User');
			
			$users = $model->find('all');
			
			//$this->out(__('Atualizando registros...'), false);
			foreach($users as $user)
			{
				$type = json_decode($user['User']['groups'], true);
				$user['User']['groups'] = $type[0];
				
				if(!$model->save($user))
				{
					//$this->out('Falha ao desatualizar campo type do modelo usuário', true);
				}
			}
			//$this->out(__('ok'));
		}

		return true;
	}

	public function after($direction)
	{
		if($direction === 'up')
		{
			// alterando o valor do campo nos registros para equivalente na notação json
			$model = $this->generateModel('User');
			
			$users = $model->find('all');
			
			//$this->out(__('Atualizando registros...'), false);
			foreach($users as $user)
			{
				$user['User']['groups'] = json_encode(array(str_replace('"', '', $user['User']['groups'])));
				
				if(!$model->save($user))
				{
					//$this->out('Falha ao desatualizar campo type do modelo usuário', true);
				}
			}

			//$this->out(__('ok'));
		}

		return true;
	}
}