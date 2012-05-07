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

	public $groups = array();

	public function before($direction)
	{
		$model = $this->generateModel('User');

		$users = $model->find('all');

		foreach($users as $user)
		{
			if($direction === 'down')
			{
				$this->groups[$user['User']['id']] = $user['User']['groups'];
			}
			else
			{
				$this->groups[$user['User']['id']] = $user['User']['type'];
			}
		}

		return true;
	}

	public function after($direction)
	{
		echo __('Atualizando registros...');
		$model = $this->generateModel('User');

		if($direction === 'down')
		{
			foreach($this->groups as $id => $group)
			{
				$type = json_decode($group, true);

				$model->create();
				$model->id = $id;
				if(!$model->saveField('type', $type[0]))
				{
					echo __('Falha ao desatualizar campo type do modelo usuário'), "\n";
				}
			}
		}
		else
		{
			foreach($this->groups as $id => $group)
			{
				$type = json_encode(array($group));

				$model->create();
				$model->id = $id;
				if(!$model->saveField('groups', $type))
				{
					echo __('Falha ao desatualizar campo type do modelo usuário'), "\n";
				}
			}
		}

		echo __('ok'), "\n\n";

		return true;
	}
}