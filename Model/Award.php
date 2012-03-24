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
}
