<?php
App::uses('BrValidation', 'Localized.Lib');
App::uses('Security', 'Utility');
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel
{
	public $name = 'User';

	public $virtualFields = array(
		'fullName' => "CONCAT(User.name, ' ', User.nickname)"
	);

	public $order = array('User.name' => 'asc');

	public $displayField = 'fullName';

	public $actsAs = array(
		'Search.Searchable',
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
				'message' => 'Forneça um endereço válido'
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, preencha o email'
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'Email já cadastrado no sistema'
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

	public $filterArgs = array(
        array('name' => 'query', 'type' => 'query', 'method' => 'searchFields')
    );

	public function beforeSave($options = array())
	{
		parent::beforeSave($options);

		if(isset($this->data['User']['password']) && !empty($this->data['User']['password']))
		{
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}

		return true;
    }

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
		if(isset($this->data[$this->alias]['id']))
		{
			return true;
		}

		if(empty($passwd))
		{
			// campo não pode estar vazio
			return false;
		}

		if(!empty($this->data[$this->alias]['password_confirm']))
		{
			$confirm = $this->data[$this->alias]['password_confirm'];

			unset($this->data[$this->alias]['password_confirm']);
		}
		// faltou campo de confirmação
		else
		{
			$this->validationErrors['password_confirm'] = 'Campo obrigatório.';

			return false;
		}

		// valida o tamanho da senha
		if(mb_strlen($passwd) < 4)
		{
			$this->validationErrors['password'] = 'A senha deve ter pelo menos 4 caracteres';

			return false;
		}

		// valida se as senhas não batem
		if($passwd != $confirm)
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
		$defaultCondition = array('User.active' => true);

		$conditions = array_merge($defaultCondition, $conditions);

		return $this->find('list', array('conditions' => $conditions));
	}

	/**
	 * Implementa busca via plugin Search
	 *
	 * @param array $data Valores para buscar
	 * @return array $conditions Condições da busca
	 */
	public function searchFields($data = array())
	{
		$filter = $data['query'];

		$conditions = array(
			'OR' => array(
				$this->alias . '.name LIKE' => '%' . $filter . '%',
				$this->alias . '.fullName LIKE' => '%' . $filter . '%',
				$this->alias . '.cpf' => $filter
			)
		);

		return $conditions;
	}
}