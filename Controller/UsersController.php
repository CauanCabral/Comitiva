<?php
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController
{
	public $name = 'Users';
	
	public $helpers = array('Locale.Locale');
	
	/***********************
	 * Public actions
	 ***********************/

	public function login()
	{
		if ($this->request->is('post'))
		{
			if ($this->Auth->login())
			{
				// verifica se usuário logado está ativo
				if($this->activeUser['User']['active'] !== true)
				{
					$this->Session->setFlash(__('Você precisa ativar sua conta. Verifique seu email por favor.'), 'default', array('class' => 'attention'));
					
					$this->redirect($this->Auth->logout());
				}
				
				$now = new DateTime();

				$this->User->id = $this->activeUser['User']['id'];
				
				// update 'last_access' field
				$this->User->saveField('last_access', $now->format("Y-m-d H:i:s"));
				
				$this->Session->setFlash(__('Você está autenticado'), 'default', array('class' => 'success'));

				return $this->redirect($this->Auth->redirect());
			}
			else
			{
				$this->Session->setFlash(__('Usuário ou senha incorreto'), 'default', array('class' => 'attention'));
			}
		}
	}
	
	public function logout()
	{
		$this->Session->setFlash(__('Você saiu do sistema'), 'default', array('class' => 'success'));

		$this->redirect($this->Auth->logout());
	}
	
	public function recover()
	{
		if (!empty($this->request->data))
		{
			$userData = $this->User->find(
				'first',
				array(
					'conditions' => array(
						'User.email' => $this->request->data['User']['email']
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
				$this->Session->setFlash(__('Endereço de email não cadastrado'), 'default', array('class' => 'attention'));
			}
		}
		else
		{
			$this->Session->setFlash(__('Você deve informar seu endereço de email cadastrado'), 'default', array('class' => 'attention'));
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
				$this->Session->setFlash(__('Token fornecido inválido. Verique o endereço acessado, por favor.'), 'default', 'attention');
				$this->redirect('/');
			}
			
			$this->set('user_id', $userToAlter['User']['id']);
			
			if(!empty($this->request->data) && $this->request->data['User']['id'] == $userToAlter['User']['id'])
			{
				$toSave = array(
					'token' => NULL,
					'token_expires_at' => NULL,
					'password' => $this->Auth->password($this->request->data['User']['new_pass']),
					'id' => $this->request->data['User']['id']
				);
				
				if($this->User->save($toSave, array('validate' => false)))
				{
					$this->Session->setFlash(__('Senha atualizada. Agora você já pode fazer seu login com a nova senha.'), 'default', 'success');
					$this->redirect(array('action' => 'login'));
				}
				else
				{
					$this->Session->setFlash(__('Falha ao atualizar senha. Tente novamente.'), 'default', array('class' => 'attention'));
				}
			}
		}
		else
		{
			$this->Session->setFlash(__('O endereço acessado não é válido.'), 'default', array('class' => 'attention'));
			$this->redirect('/');
		}
	}
	
	public function account_create()
	{
		if (!empty($this->request->data))
		{
			// define grupo inicial do usuário
			$this->request->data['User']['groups'] = json_encode(array('participant'));
			
			if($this->User->save($this->request->data))
			{
				if($this->__sendAccountConfirmMail($this->User->read()))
				{
					$this->redirect('login');
				}
			}
			else
			{
				if(isset($this->request->data['User']['password']))
					unset($this->request->data['User']['password']);
				
				if(isset($this->request->data['User']['password_confirm']))
					unset($this->request->data['User']['password_confirm']);
				
				$this->Session->setFlash(__('Não foi possível criar a conta. Verifique os dados inseridos.'), 'default', array('class' => 'attention'));
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
				$this->Session->setFlash(__('Seu cadastro já foi verificado'), 'default', array('class' => 'attention'));
				$this->redirect('/');
			}
			if($userData['User']['account_validation_token'] == $hash)
			{
				$userData['User']['account_validation_token'] = null;
				$userData['User']['account_validation_expires_at'] = null;
				$userData['User']['active'] = true;
				
				$this->User->save($userData);
				
				$this->Session->setFlash(__('Cadastro Verificado com Sucesso!'), 'default', array('class' => 'success'));
				$this->redirect('/');
			}
			else
			{
				$this->Session->setFlash(__('Código de verificação inválido!'), 'default', array('class' => 'attention'));
				$this->redirect('/');
			}
		}
		
		$this->Session->setFlash(__('Corrija o nome de usuário e/ou código de verificação!'), 'default', array('class' => 'attention'));
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
			$this->Session->setFlash(__('Usuário inválido'), 'default', array('class' => 'attention'));
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
		if (!empty($this->request->data))
		{
			// default, all admin added user has confirmed
			$this->request->data['User']['active'] = true;
			
			// default group (all user are in participant group
			$groups = array('participant');
			
			if(is_array($this->request->data['User']['groups']) && !empty($this->request->data['User']['groups']))
			{
				$groups = array_merge($groups, $this->request->data['User']['groups']);
				$groups = json_encode($this->request->data['User']['groups']);
			}
			
			$this->request->data['User']['groups'] = $groups;
			
			if ($this->User->save($this->request->data))
			{
				$this->Session->setFlash(__('Usuário adicionado'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				if(isset($this->request->data['User']['password']))
					unset($this->request->data['User']['password']);
				
				if(isset($this->request->data['User']['password_confirm']))
					unset($this->request->data['User']['password_confirm']);
					
				$this->request->data['User']['groups'] = json_decode($groups, true);
					
				$this->Session->setFlash(__('Usuário não pode ser salvo. Tente novamente, por favor.'), 'default', array('class' => 'attention'));
			}
		}
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->Session->setFlash(__('Usuário inválido'), 'default', array('class' => 'attention'));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->request->data))
		{
			$this->request->data['User']['groups'] = json_encode($this->request->data['User']['groups']);
			
			if ($this->User->save($this->request->data))
			{
				// se o admin está editando sua própria conta
				if($this->request->data['User']['id'] == User::get('id'))
				{
					// recarrega suas informações
					$this->__reloadUserInfo();
				}
				
				$this->Session->setFlash(__('Usuário salvo'), 'default', array('class' => 'success'));
				$this->__goBack();
			}
			else
			{
				$this->request->data['User']['groups'] = json_decode($this->request->data['User']['groups'], true);
				
				$this->Session->setFlash(__('Não foi possível salvar a alteração. Tente novamente, por favor.'), 'default', array('class' => 'attention'));
			}
		}
		
		if (empty($this->request->data))
		{
			$this->request->data = $this->User->read(null, $id);
			$this->request->data['User']['groups'] = json_decode($this->request->data['User']['groups']);
		}
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Usuário inválido'), 'default', array('class' => 'attention'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('Usuário removido'), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Usuário não pode ser removido'), 'default', array('class' => 'attention'));
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
		if(!empty($this->request->data))
		{
			// force field id to use User logged id
			$this->request->data['User']['id'] = User::get('id');
			// force field username to use User logged username
			$this->request->data['User']['username'] = User::get('username');
			
			if($this->User->save($this->request->data))
			{
				$this->__reloadUserInfo();
				$this->Session->setFlash(__('Dados Atualizados!'), 'default', array('class' => 'success'));
				//_goBack leva a redirecionamento infinito. por que?
				$this->redirect('/');
			}
			else
			{
				$this->Session->setFlash(__('Erro ao Atualizar Dados'), 'default', array('class' => 'attention'));
			}
		}
		
		// read and set the User data based on value of logged user
		$this->request->data = $this->User->read(null, User::get('id'));
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
			$email = new CakeEmail();
			
			/* Setup parameters of EmailComponent */
			$email->to($userData['User']['email'])
					->subject('[PHPMS - Inscrições] Pedido para recuperar senha')
					->replyTo(Cofigure::read('Message.from'))
					->from('PHPMS <' . Cofigure::read('Message.from') . '>')
					->template('reset_password')
					->emailFormat('html');

			if($email->send())
			{
				$this->Session->setFlash(__('Instruções para redefinir a senha foram enviadas para seu email cadastrado'), 'default', array('class' => 'success'));
				return true;
			}
			else
			{
				$this->Session->setFlash(sprintf(__('Não foi possível enviar as informações de recuperação de senha para seu email. Entre em contato através do email %s para obter ajuda'), Configure::read('Message.from')), 'default', array('class' => 'attention'));
			}
		}
		else
		{
			$this->Session->setFlash(sprintf(__('Não foi possível iniciar processo para rercuperação da senha. Entre em contato através do email %s para obter ajuda'), Configure::read('Message.from')), 'default', array('class' => 'attention'));
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
		
		$token = sha1(md5($this->request->data['User']['password']) . time());
		
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
			$email = new CakeEmail();
			
			/* Setup parameters of EmailComponent */
			$email->to($userData['User']['email'])
					->subject('[PHPMS - Inscrições] Confirmação de conta')
					->replyTo(Cofigure::read('Message.from'))
					->from('PHPMS <' . Cofigure::read('Message.from') . '>')
					->template('account_confirm')
					->emailFormat('html');
	
			if($email->send())
			{
				$this->Session->setFlash(__('Foi enviado um email para confirmação da sua conta'), 'default', array('class' => 'attention'));
				return true;
			}
			else
			{
				$this->Session->setFlash(sprintf(__('Não foi possível enviar o email de confirmação da conta para seu endereço. Entre em contato através do email %s para obter ajuda'), Configure::read('Message.from')), 'default', array('class' => 'attention'));
			}
		}
		else
		{
			$this->User->delete($userData['User']['id']);
			$this->Session->setFlash(sprintf(__('Não foi possível enviar o email de confirmação da conta para seu endereço. Entre em contato através do email %s para obter ajuda'), Configure::read('Message.from')), 'default', array('class' => 'attention'));
		}
		
		return false;
	}
}