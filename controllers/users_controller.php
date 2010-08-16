<?php
class UsersController extends AppController
{
	public $name = 'Users';
	
	public $components = array('Email');
	
	public $helpers = array('Locale', 'Formatacao');
	
	public $uses = array('User');
	
	/***********************
	 * Public actions 
	 ***********************/

	public function login()
	{
		if($this->Auth->user())
		{	
			// load user model and save data user to direct access
			$this->User->store($this->Auth->user());
			
			// verify if logged user has active account
			if(User::get('active') == 0)
			{
				// if not, force loggout and display help message to user active account
				$this->userLogged = false;
				
				$this->Session->setFlash(__('Você precisa ativar sua conta. Verifique seu email por favor.', TRUE), 'default', array('class' => 'attention'));
				
				$this->redirect($this->Auth->logout());
			}
			
			$now = new DateTime();
			
			// init model user to update field
			$this->User->create(User::get('User'));
			
			// update 'last_access' field
			$this->User->saveField('last_access', $now->format("Y-m-d H:i:s"));
			
			$this->Session->setFlash(__('Você está autenticado', 1), 'default', array('class' => 'success'));

			// redirect
			$this->redirect($this->Auth->redirect());
		}
	}
	
	public function logout()
	{
		$this->Session->setFlash(__('Você saiu do sistema', 1), 'default', array('class' => 'success'));

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

			if(!empty($userData))
			{
				$this->__sendLinkToMail($userData);
			}
			else
			{
				$this->Session->setFlash(__('Endereço de email não cadastrado', 1), 'default', array('class' => 'attention'));
			}
		}
		else
		{
			$this->Session->setFlash(__('Você deve informar seu endereço de email cadastrado', 1), 'default', array('class' => 'attention'));
		}
	}
	
	public function reset_password($secureHash = '')
	{
		if(!empty($secureHash))
		{
			$this->set('secureHash', $secureHash);
			
			$userToAlter = $this->User->find(
				'first',
				array(
					'conditions' => array(
						'User.token' => $secureHash
					),
					'recursive' => -1
				)
			);
			
			if(empty($userToAlter))
			{
				$this->Session->setFlash(__('Token fornecido inválido. Verique o endereço acessado, por favor.', TRUE), 'default', 'attention');
				$this->redirect('/');
			}
			
			$this->set('user_id', $userToAlter['User']['id']);
			
			if(!empty($this->data) && $this->data['User']['id'] == $userToAlter['User']['id'])
			{
				$toSave = array(
					'token' => NULL,
					'token_expires_at' => NULL,
					'password' => $this->Auth->password($this->data['User']['new_pass']),
					'id' => $this->data['User']['id']
				);
				
				if($this->User->save($toSave, array('validate' => false)))
				{
					$this->Session->setFlash(__('Senha atualizada. Agora você já pode fazer seu login com a nova senha.', TRUE), 'default', 'success');
					$this->redirect(array('action' => 'login'));
				}
				else
				{
					$this->Session->setFlash(__('Falha ao atualizar senha. Tente novamente.', TRUE), 'default', array('class' => 'attention'));
				}
			}
		}
		else
		{
			$this->Session->setFlash(__('O endereço acessado não é válido.', TRUE), 'default', array('class' => 'attention'));
			$this->redirect('/');
		}
	}
	
	public function account_create()
	{
		if (!empty($this->data))
		{
			// define grupo inicial do usuário
			$this->data['User']['groups'] = json_encode(array('participant'));
			
			if($this->User->save($this->data))
			{
				if($this->__sendAccountConfirmMail($this->User->read()))
				{
					$this->redirect('login');
				}
			}
			else
			{
				if(isset($this->data['User']['password']))
					unset($this->data['User']['password']);
				
				if(isset($this->data['User']['password_confirm']))
					unset($this->data['User']['password_confirm']);
				
				$this->Session->setFlash(__('Não foi possível criar a conta. Verifique os dados inseridos.', true), 'default', array('class' => 'attention'));
			}
		}
	}

	public function account_confirm($hash = NULL,$user)
	{
		if(isset($hash) && isset($user))
		{
			$userData = $this->User->find('first', array(
				'conditions' => array(
					'username' => $user
				)
			));
			if($userData['User']['active'])
			{
				$this->Session->setFlash(__('Seu cadastro já foi verificado',1), 'default', array('class' => 'attention'));
				$this->redirect('/');
			}
			if($userData['User']['account_validation_token'] == $hash)
			{
				$userData['User']['account_validation_token'] = null;
				$userData['User']['account_validation_expires_at'] = null;
				$userData['User']['active'] = true;
				
				$this->User->save($userData);
				
				$this->Session->setFlash(__('Cadastro Verificado com Sucesso!',1), 'default', array('class' => 'success'));
				$this->redirect('/');
			}
			else
			{
				$this->Session->setFlash(__('Código de verificação inválido!',1), 'default', array('class' => 'attention'));
				$this->redirect('/');
			}
		}
		
		$this->Session->setFlash(__('Corrija o nome de usuário e/ou código de verificação!',1), 'default', array('class' => 'attention'));
		$this->redirect('/');
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
			$this->Session->setFlash(__('Usuário inválido', true), 'default', array('class' => 'attention'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->find(
			'first',
			array(
				'conditions' => array(
					'User.id' => $id
					),
				'recursive' => 2
				)
			)
		);
	}

	public function admin_add()
	{
		if (!empty($this->data))
		{
			// default, all admin added user has confirmed
			$this->data['User']['active'] = TRUE;
			
			// default group (all user are in participant group
			$groups = array('participant'); 
			
			if(is_array($this->data['User']['groups']) && !empty($this->data['User']['groups']))
			{
				$groups = array_merge($groups, $this->data['User']['groups']);
				$groups = json_encode($this->data['User']['groups']);
			}
			
			$this->data['User']['groups'] = $groups;
			
			if ($this->User->save($this->data))
			{
				$this->Session->setFlash(__('Usuário adicionado', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				if(isset($this->data['User']['password']))
					unset($this->data['User']['password']);
				
				if(isset($this->data['User']['password_confirm']))
					unset($this->data['User']['password_confirm']);
					
				$this->data['User']['groups'] = json_decode($groups, true);
					
				$this->Session->setFlash(__('Usuário não pode ser salvo. Tente novamente, por favor.', true), 'default', array('class' => 'attention'));
			}
		}
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Usuário inválido', true), 'default', array('class' => 'attention'));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data))
		{
			$this->data['User']['groups'] = json_encode($this->data['User']['groups']);
			
			if ($this->User->save($this->data))
			{
				// se o admin está editando sua própria conta
				if($this->data['User']['id'] == User::get('id'))
				{
					// recarrega suas informações
					$this->__reloadUserInfo();
				}
				
				$this->Session->setFlash(__('Usuário salvo', true), 'default', array('class' => 'success'));
				$this->__goBack();
			}
			else
			{
				$this->data['User']['groups'] = json_decode($this->data['User']['groups'], true);
				
				$this->Session->setFlash(__('Não foi possível salvar a alteração. Tente novamente, por favor.', true), 'default', array('class' => 'attention'));
			}
		}
		
		if (empty($this->data))
		{
			$this->data = $this->User->read(null, $id);
			$this->data['User']['groups'] = json_decode($this->data['User']['groups']);
		}
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Usuário inválido', true), 'default', array('class' => 'attention'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('Usuário removido', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Usuário não pode ser removido', true), 'default', array('class' => 'attention'));
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
	
	public function participant_edit()
	{
		if(!empty($this->data))
		{
			// force field id to use User logged id
			$this->data['User']['id'] = User::get('id');
			// force field username to use User logged username
			$this->data['User']['username'] = User::get('username');
			
			if($this->User->save($this->data))
			{
				$this->__reloadUserInfo();
				$this->Session->setFlash(__('Dados Atualizados!',1), 'default', array('class' => 'success'));
				//_goBack leva a redirecionamento infinito. por que?
				$this->redirect('/');
			}
			else
			{
				$this->Session->setFlash(__('Erro ao Atualizar Dados',1), 'default', array('class' => 'attention'));
			}
		}
		
		// read and set the User data based on value of logged user
		$this->data = $this->User->read(null, User::get('id'));
	}
	
	/***************************
	 * Auxiliar methods
	 **************************/
	
	/**
	 * Recupera informações atualizadas do usuário logado e salva na seção
	 * os novos valores
	 * 
	 * @return void
	 */
	protected function __reloadUserInfo()
	{
		$user = $this->User->read(null, User::get('id'));
		
		//remove chaves desnecessárias para a sessão
		unset($user['User']['password'], $user['User']['token'], $user['User']['account_validation_token']);
		
		// escreve trecho pertinente da sessão
		$this->Session->write('Auth.User', $user['User']);
	}
	
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
		
		$token_expires = $d->format('Y-m-d H:i:s');  

		$success = $this->User->save(
			array(
				'User' => array(
					'id' => $userData['User']['id'],
					'token' => $secureHash,
					'token_expires_at' => $token_expires
				)
			)
		);
		$this->set('user', $userData['User']['name']);
		$this->set('token', $secureHash);

		if($success)
		{
			$this->Email->reset();

			/* Setup parameters of EmailComponent */
			$this->Email->to = $userData['User']['email'];
			$this->Email->subject = '[PHPMS - Inscrições] Pedido para recuperar senha';
			$this->Email->replyTo = Cofigure::read('Message.from');
			$this->Email->from = 'PHPMS <' . Cofigure::read('Message.from') . '>';
			$this->Email->template = 'reset_password';
			$this->Email->charset = 'utf-8';

			$this->Email->sendAs = 'html';

			if($this->Email->send())
			{
				$this->Session->setFlash(__('Instruções para redefinir a senha foram enviadas para seu email cadastrado', true), 'default', array('class' => 'success'));
				return true;
			}
			else
			{
				$this->Session->setFlash(sprintf(__('Não foi possível enviar as informações de recuperação de senha para seu email. Entre em contato através do email %s para obter ajuda', true), Configure::read('Message.from')), 'default', array('class' => 'attention'));
			}
		}
		else
		{
			$this->Session->setFlash(sprintf(__('Não foi possível iniciar processo para rercuperação da senha. Entre em contato através do email %s para obter ajuda',true), Configure::read('Message.from')), 'default', array('class' => 'attention'));
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
		$d = new DateTime();
		$d->modify('+1 day');
		
		$token = sha1(md5($this->data['User']['password']) . time());
		
		$success = $this->User->save(
			array(
				'User' => array(
					'id' => $userData['User']['id'],
					'account_validation_token' => $token,
					'account_validation_expires_at' => $d->format('Y-m-d H:i:s')
				)
			)
		);
		
		$this->set('user', $userData['User']);
		$this->set('token', $token);
		
		if($success)
		{
			$this->Email->reset();
		
			/* Setup parameters of EmailComponent */
			$this->Email->to = $userData['User']['email'];
			$this->Email->subject = '[PHPMS - Inscrições] Confirmação de conta';
			$this->Email->replyTo = Configure::read('Message.from');
			$this->Email->from = 'PHPMS <' . Configure::read('Message.from') . '>';
			$this->Email->template = 'account_confirm';
			$this->Email->charset = 'utf-8';
	
			$this->Email->sendAs = 'html';
	
			if($this->Email->send())
			{
				$this->Session->setFlash(__('Foi enviado um email para confirmação da sua conta', true), 'default', array('class' => 'attention'));
				return true;
			}
			else
			{
				$this->Session->setFlash(sprintf(__('Não foi possível enviar o email de confirmação da conta para seu endereço. Entre em contato através do email %s para obter ajuda', true), Configure::read('Message.from')), 'default', array('class' => 'attention'));
			}
		}
		else
		{
			$this->User->delete($userData['User']['id']);
			$this->Session->setFlash(sprintf(__('Não foi possível enviar o email de confirmação da conta para seu endereço. Entre em contato através do email %s para obter ajuda', true), Configure::read('Message.from')), 'default', array('class' => 'attention'));
		}
		
		return false;
	}
}
?>