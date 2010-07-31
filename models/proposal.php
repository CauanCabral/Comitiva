<?php
class Proposal extends AppModel {
	var $name = 'Proposal';
	var $displayField = 'abstract';
	var $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Não foi possível encontrar o seu identificador de usuário.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
    'event_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Você precisa selecionar um evento',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mini_curriculum' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Você precisa fornecer o seu mini-currículo.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'abstract' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Você precisa definir o resumo da sua apresentação.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'detailed' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Você precisa fornecer uma descrição detalhada da sua apresentação.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
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
?>