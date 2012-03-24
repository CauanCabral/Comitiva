<?php
App::uses('AppModel', 'Model');
/**
 * Raffle Model
 *
 */
class Raffle extends AppModel 
{
	public $belongsTo = array('User', 'Award');

	/**
	*
	*/
	public function random($reincident = true)
	{
		$users = $this->User->find('list', array(
			'fields' => array('name'),
			'conditions' => array(
				'groups' => array('["participant"]')
			)
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

		$key = $this->getRandKey($quantity-1);

		if(!$reincident)
		{
			$raffles = array();
			while(count($raffles) > 0)
			{
				$raffles = $this->find('all', array(
					'conditions' => array(
						'user_id' => $userslist[$key]['id']
					),
					'fields' => array('id')
				));

				$key = $this->getRandKey($quantity-1);
			}

		}

		return $userlist[$key];
	}

	protected function getRandKey($max)
	{
		list($usec, $sec) = explode(' ', microtime());
  		$seed = (float) $sec + ((float) $usec * 100000);	
		mt_srand($seed);
		
		return mt_rand(0, $max);
	}

}
