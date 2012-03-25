<?php
App::uses('AppModel', 'Model');
/**
 * Award Model
 *
 */
class Award extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	public $hasMany = array('Raffle');
	public $belongsTo = array('Event');

	public function getList()
	{
		$awards = $this->find('all' , array(
			'contain' => array('Event')
		));

		$result = array();

		foreach($awards as $award)
		{
			$result[$award['Award']['id']] = $award['Award']['title'] . ' - ' . $award['Event']['title'];
		}

		return $result;
	}
}
