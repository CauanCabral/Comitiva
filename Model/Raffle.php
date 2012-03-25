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
	public function random($award_id, $reincident = true)
	{
		$Subscription = ClassRegistry::init('Subscription');

		$award = $this->Award->find('first', array(
			'conditions' => array(
				'Award.id' => $award_id
			),
			'contain' => array('Event')
		));

		$groups = json_decode($award['Award']['groups']);

		$winners = array();

		foreach ($groups as $group) {
			$winners[] = '["' . $group . '"]';
		}

		$winners = array_merge($winners, array('["participant","speaker"]'));

		$subscriptions = $Subscription->find('list', array(
			'conditions' => array(
				'event_id' => $award['Event']['id'],
				'checked' => 1
			),
			'fields' => array('id', 'user_id')
		));

		$users = $this->User->find('list', array(
			'fields' => array('name'),
			'conditions' => array(
				'groups' => $winners,
				'User.id' => array_values($subscriptions)
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
						'user_id' => $userslist[$key]['id'],
						'award_id' => $award_id
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
