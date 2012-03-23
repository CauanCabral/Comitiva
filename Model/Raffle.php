<?php
App::uses('AppModel', 'Model');
/**
 * Raffle Model
 *
 */
class Raffle extends AppModel 
{
	public $belongsTo = array('User');
	public function random()
	{
		$userlist = $this->User->find('list', array(
			'fields' => array('name')
		));

		$userlist = array_values($userlist);
		$quantity = count($userlist);

		if($quantity == 0)
			return 0;

		list($usec, $sec) = explode(' ', microtime());
  		$seed = (float) $sec + ((float) $usec * 100000);	
		mt_srand($seed);
		
		$key = mt_rand(0, $quantity-1);

		return $userlist[$key];
	}
}
