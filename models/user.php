<?php
App::import('Lib', 'Localized.BrValidation');

class User extends AppModel
{
	public $name = 'User';
	
	public $virtualFields = array(
		'fullName' => "CONCAT(User.name, ' ', User.nickname)"
	);
	
	public $displayField = 'fullName';
	
	public $actsAs = array(
		'Locale.Locale'
	);
	
	public $validate = array(
		'username' => array(
			'notempty' => array('rule' => array('notempty'),
                                'message' => 'Por favor, preencha o username'),
			'unique' => array('rule' => array('isUnique')),
			'alphanumeric' => array('rule' => array('alphanumeric'))
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
			),
			'notempty' => array(
				'rule' => array('notempty'),
                                'message' => 'Por favor, preencha o email'
			),
			'unique' => array(
				'rule' => array('isUnique')
			)
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, preencha o nome'
			)
		),
		'nickname' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, preencha o sobrenome'
			)
		),
		'birthday' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Informação obrigatória para geração de certificado'
			),
			'valid' => array(
				'rule' => array('date'),
				'message' => 'Data inválida'
			)
		),
		'cpf' => array(
			'cpf' => array(
				'rule' => array('ssn', null, 'br'),
				'message' => 'Verifique o número digitado'
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Informação obrigatória para geração de certificado'
			)
		),
		'address' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, preencha o endereço'
			)
		)
	);

	public $hasMany = array(
		'Subscription' => array(
			'className' => 'Subscription',
			'foreignKey' => 'user_id',
			'dependent' => false
		)
	);
	
	/**
	 * Método auxiliar para recuperar lista com usuários ativos
	 * 
	 * @param array $conditions
	 * @return array - lista de usuários (equivalente a User::find('list'))
	 */
	public function getList($conditions = array())
	{
		$defaultCondition = array('User.active' => TRUE);
		
		$conditions = array_merge($defaultCondition, $conditions);
		
		return $this->find('list', array('conditions' => $conditions));
	}
	
	/**
	 * **************************************************
	 * Begin of copyrighted content to Matt Curry
	 * **************************************************
	 * 
	 * Static methods that can be used to retrieve the logged in user
	 * from anywhere
	 *
	 * Copyright (c) 2008 Matt Curry
	 * www.PseudoCoder.com
	 * http://github.com/mcurry/cakephp/tree/master/snippets/static_user
	 * http://www.pseudocoder.com/archives/2008/10/06/accessing-user-sessions-from-models-or-anywhere-in-cakephp-revealed/
	 *
	 * @author      Matt Curry <matt@pseudocoder.com>
	 * @license     MIT
	 */
	public static function &getInstance($user=null)
	{
		static $instance = array();

		if ($user)
		{
			$instance[0] = $user;
		}

		if (!$instance)
		{
			trigger_error(__("User not set.", true), E_USER_WARNING);
			return false;
		}

		return $instance[0];
	}

	public static function store($user)
	{
		if (empty($user))
		{
			return false;
		}

		User::getInstance($user);
	}

	public function get($path)
	{
		$_user = User::getInstance();

		$path = str_replace('.', '/', $path);
		
		if (strpos($path, 'User') !== 0)
		{
			$path = sprintf('User/%s', $path);
		}

		if (strpos($path, '/') !== 0)
		{
			$path = sprintf('/%s', $path);
		}

		$value = Set::extract($path, $_user);

		if (!$value)
		{
			return false;
		}

		return $value[0];
	}
	
	/**
	 * *****************************************
	 * End of copyright to Matt Curry
	 */

}
?>
