<?php
class Proposal extends AppModel {
	public $name = 'Proposal';
	public $displayField = 'abstract';
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Não foi possível encontrar o seu identificador de usuário.',
				'allowEmpty' => false,
				'required' => true,
			),
		),
    	'event_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Você precisa selecionar um evento',
				'allowEmpty' => false,
				'required' => true,
			),
		),
		'mini_curriculum' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Você precisa fornecer o seu mini-currículo.',
			),
		),
		'abstract' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Você precisa definir o resumo da sua apresentação.',
			),
		),
		'detailed' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Você precisa fornecer uma descrição detalhada da sua apresentação.',
			),
		),
	);

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    	'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}