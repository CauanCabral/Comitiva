<?php
App::uses('AppModel', 'Model');
/**
 * Raffle Model
 *
 */
class Raffle extends AppModel 
{
	public $belongsTo = array('User');

	/**
	*
	*/
	public function random($reincident = true)
	{
		$users = $this->User->find('list', array(
			'fields' => array('name')
		));

		$quantity = count($users);

		if($quantity == 0)
			return 0;

		foreach($users as $id => $name)
		{
			$userlist[] = array(
				'id' => $id,
				'name' => $name
			);
		}

		list($usec, $sec) = explode(' ', microtime());
  		$seed = (float) $sec + ((float) $usec * 100000);	
		mt_srand($seed);
		$key = mt_rand(0, $quantity-1);

		if(!$reincident)
		{
			$raffles = $this->find('first', array(
				'conditions' => array(
					'user_id' => $userslist[$key]['id']
				)
			));

		}

		return $userlist[$key];
	}
}
