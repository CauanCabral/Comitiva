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
				'groups' => array('["participant"]', '["speaker"]')
			)
		));

		$quantity = count($users);

		if($quantity == 0)
			return 0;

		$userslist = array();

		foreach($users as $id => $name)
		{
			$userslist[] = array(
				'id' => $id,
				'name' => $name
			);
		}

		$key = $this->getRandKey($quantity-1);

		if(!$reincident)
		{
			$raffles = array();
			$i = 0;
			while($i <= $quantity)
			{
				$raffles = $this->find('all', array(
					'conditions' => array(
						'user_id' => $userslist[$key]['id']
					),
					'fields' => array('id')
				));

				$i++;
				if(!empty($raffles))
					continue;

				return $userslist[$key];
			}	

			return 0;
		}

		return $userslist[$key];
	}

	protected function getRandKey($max)
	{
		list($usec, $sec) = explode(' ', microtime());
  		$seed = (float) $sec + ((float) $usec * 100000);	
		mt_srand($seed);
		
		return mt_rand(0, $max);
	}

}
