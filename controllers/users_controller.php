<?php
class UsersController extends AppController
{

	public $name = 'Users';
	
	public $components = array('Email');
	
	public $helpers = array('Locale');
	
	public $uses = array('User');
	
	public function isAuthorized()
	{
		if($this->userLogged === TRUE && $this->params['prefix'] == User::get('type'))
		{
			return true;
		}
		else if(empty($this->params['prefix']))
		{
			return true;
		}
		
		return false;
	}
	
	/***********************
	 * Public actions 
	 ***********************/
	
	public function login()
	{
		if($this->Auth->user())
		{
			// display a response
			$this->Session->setFlash(__('Você está autenticado', 1));
			
			$now = new DateTime();
			
			// load user model
			$this->User->create($this->Auth->user());
			
			// update 'last_access' field
			$this->User->saveField('last_access', $now->format(DateTime::ISO8601));
			
			// redirect
			$this->redirect($this->Auth->loginRedirect);
		}
		else
		{
			$this->userLogged = false;
		}
	}
	
	public function logout()
	{
		$this->Session->setFlash(__('Você saiu do sistema', 1));

		$this->redirect($this->Auth->logout());
	}
	
	public function recover()
	{
		if (!empty($this->data))
		{
			$userData = $this->User->find(
				'first',
				array(
					'conditions' => array(
						'User.email' => $this->data['User']['email']
					),
					'contains' => array()
				)
			);

			if(is_array($userData) && !empty($userData))
			{
				$this->__sendLinkToMail($userData);
			}
		}
	}
	
	public function reset_password($secureHash = '')
	{
		if(!empty($secureHash))
		{
			if(!empty($this->data) && $this->data['User']['id'] == $userToAlter['User']['id'])
			{
				$toSave = array(
					'password' => $this->Auth->password($this->data['User']['new_pass']),
					'id' => $this->data['User']['id']
				);
				$this->User->save($toSave);
			}
		}

		$userToAlter = $this->User->find(
				'first',
				array(
					'conditions' => array(
						'User.reset' => $secureHash
					),
					'contains' => array()
				)
			);

		if(empty($userToAlter))
		{
			$this->Session->setFlash('Você não possui autorização para executar esta tarefa. Verique o endereço acessado, por favor.');
		}
	}
	
	public function account_create()
	{
		if (!empty($this->data))
		{
			$d = new DateTime();
			$d->modify('+1 day');
		
			$this->data['User']['account_validation_expires_at'] = $d->format(DateTime::ISO8601);
			$this->data['User']['account_validation_token'] = sha1(md5($this->data['User']['password']) . time());
			
			$this->User->create($this->data);
			
			if ($this->User->save())
			{
				$this->__sendAccountConfirmMail($this->User->read());
				
				$this->redirect('/login');
			}
			else
			{
				$this->Session->setFlash(__('Não foi possível criar a conta. Verifique os dados inseridos.', true));
			}
		}
	}

	/*******************
	 * Admin actions
	 ******************/
	
	public function admin_profile()
	{	
		$this->set('user', User::get('User'));
		$this->render('profile');
	}
	
	public function admin_index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function admin_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Usuário inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	public function admin_add()
	{
		if (!empty($this->data))
		{
			$this->User->create();
			
			if ($this->User->save($this->data))
			{
				$this->Session->setFlash(__('Usuário adicionado', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Usuário não pode ser salvo. Tente novamente, por favor.', true));
			}
		}
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Usuário inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data))
		{
			if ($this->User->save($this->data))
			{
				$this->Session->setFlash(__('Usuário salvo', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Não foi possível salvar a alteração. Tente novamente, por favor.', true));
			}
		}
		
		if (empty($this->data))
		{
			$this->data = $this->User->read(null, $id);
		}
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Usuário inválido', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('Usuário removido', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Usuário não pode ser removido', true));
		$this->redirect(array('action' => 'index'));
	}
	
	/***************************
	 * Participant actions
	 ***************************/
	
	public function participant_profile()
	{	
		$this->set('user', User::get('User'));
		$this->render('profile');
	}
	
	/***************************
	 * Auxiliar methods
	 **************************/
	
	/**
	 * Envia um email para o endereço associado ao usuário
	 * com informações para recuperação da senha
	 * 
	 * @param array $userData
	 * @return bool
	 */
	protected function __sendLinkToMail($userData)
	{
		$secureHash = sha1($userData['User']['password'] . time());
		
		$d = new DateTime();
		$d->modify('+1 day');
		
		$token_expires = $d->format(DateTime::ISO8601);  

		$success = $this->User->save(
			array(
				'User' => array(
					'id' => $userData['User']['id'],
					'token' => $secureHash,
					'token_expires_at' => $token_expires
				)
			)
		);
		
		$this->set('token', $secureHash);

		if($success)
		{
			$this->Email->reset();

			/* Setup parameters of EmailComponent */
			$this->Email->to = $userData['User']['email'];
			$this->Email->subject = '[PHPMS - Inscrições] Pedido para recuperar senha';
			$this->Email->replyTo = 'admin.phpms@gmail.com';
			$this->Email->from = 'PHPMS <admin.phpms@gmail.com>';
			$this->Email->template = 'reset_password';
			$this->Email->charset = 'utf-8';

			$this->Email->sendAs = 'html';

			if($this->Email->send())
			{
				$this->Session->setFlash('Instruções para redefinir a senha foram enviadas para seu email cadastrado.');
				return true;
			}
			else
			{
				$this->Session->setFlash('Não foi possível enviar as informações de recuperação de senha para seu email. Entre em contato através do email admin.phpms@gmail.com para obter ajuda.');
			}
		}
		else
		{
			$this->Session->setFlash('Não foi possível iniciar processo para rercuperação da senha. Entre em contato através do email admin.phpms@gmail.com para obter ajuda.');
		}

		return false;
	}
	
	/**
	 * Envia um email para o usuário com os dados de sua conta
	 * * Não inclui senha
	 * 
	 * @param array $userData
	 * @return bool
	 */
	protected function __sendAccountConfirmMail($userData)
	{		
		$this->set('token', $user['User']['account_validation_token']);
		
		if($success)
		{
			$this->Email->reset();
	
			/* Setup parameters of EmailComponent */
			$this->Email->to = $userData['User']['email'];
			$this->Email->subject = '[PHPMS - Inscrições] Confirmação de conta';
			$this->Email->replyTo = 'admin.phpms@gmail.com';
			$this->Email->from = 'PHPMS <admin.phpms@gmail.com>';
			$this->Email->template = 'account_confirm';
			$this->Email->charset = 'utf-8';
	
			$this->Email->sendAs = 'html';
	
			if($this->Email->send())
			{
				$this->Session->setFlash('Foi enviado um email para confirmação da sua conta.');
				return true;
			}
			else
			{
				$this->Session->setFlash('Não foi possível enviar o email de confirmação da conta para seu endereço. Entre em contato através do email admin.phpms@gmail.com para obter ajuda.');
			}
		}
		
		return false;
	}
}
?>