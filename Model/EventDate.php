<?php
class EventDate extends AppModel
{
	public $name = 'EventDate';

	public $actsAs = array(
		'Locale.Locale'
	);

	public $order = 'EventDate.date ASC';

	public $virtualFields = array(
		'time' => "TIME(`EventDate`.`date`)"
	);

	public $validate = array(
		'date' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Obrigatório uma data'
			),
		),
		'desc' => array(
			'length' => array(
				'rule' => array('maxLength', 30),
				'message' => 'Descrição muito longa. Limite de 30 caracteres.'
				)
		)
	);

	public $belongsTo = array('Event');
}