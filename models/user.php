<?php
App::import('Lib', 'Localized.BrValidation');

App::import('Core', 'Security', false);

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
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, preencha o nome de usuário'
				),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'O nome de usuário deve ser único'
				),
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'São permitido apenas letras e números'
				)
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
		'password' => array(
			'password' => array(
				'rule' => array('passwordIsValid'),
				'message' => 'Campo obrigatório. São aceitos letras e números. No mínimo 4 caracteres'
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
	 * Método para validar a senha do usuário
	 * 
	 * Critérios:
	 *  - aceita quaisquer caracteres (especiais inclusive)
	 *  - pelo menos 4 caracteres
	 *  - campo de confirmação (password_confirm) deve estar preenchido e ter o mesmo valor
	 *  
	 * @param $check array
	 * @return bool $isValid
	 */
	public function passwordIsValid($check = null)
	{
		$passwd = $check['password'];
		
		// caso seja uma atualização do registro (onde a senha não pode ser alterada)
		if(isset($this->data[$this->name]['id']))
		{
			return true;
		}
		
		if(empty($passwd))
		{
			// campo não pode estar vazio
			return false;
		}
		
		if(!empty($this->data[$this->name]['password_confirm']))
		{
			$confirm = $this->data[$this->name]['password_confirm'];
			
			unset($this->data[$this->name]['password_confirm']);
		}
		// faltou campo de confirmação
		else
		{
			$this->validationErrors['password_confirm'] = 'Campo obrigatório.';
			
			return false;
		}
		
		// valida o tamanho da senha, pela sua confirmação
		if(mb_strlen($confirm) < 4)
		{
			$this->validationErrors['password_confirm'] = 'A senha deve ter pelo menos 4 caracteres';
			
			return false;
		}
		
		$hash = Security::hash($confirm, null, true);
		
		// valida se o hash da senha é o mesmo da confirmação
		if($passwd != $hash)
		{
			$this->validationErrors['password_confirm'] = 'Campo não bate com a senha';
			
			return false;
		}
		
		return true;
	}
	
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
