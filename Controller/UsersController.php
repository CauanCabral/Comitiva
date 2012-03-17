<?php
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController
{
	public $name = 'Users';

	public $helpers = array('Locale.Locale');

	/***********************
	 * Ações publicas
	 ***********************/

	public function login()
	{
		if(!empty($this->activeUser))
		{
			$this->__setFlash('Você está autenticado', 'success');
			$this->redirect($this->Auth->redirect());
		}

		if ($this->request->is('post'))
		{
			if ($this->Auth->login())
			{
				$this->activeUser = $this->Auth->user();

				// verifica se usuário logado está ativo
				if(empty($this->activeUser['active']))
				{
					$this->__setFlash('Você precisa ativar sua conta. Verifique seu email por favor.', 'attention');

					$this->redirect($this->Auth->logout());
				}

				$now = new DateTime();

				$this->User->id = $this->activeUser['id'];

				// update 'last_access' field
				$this->User->saveField('last_access', $now->format("Y-m-d H:i:s"));

				$this->__setFlash('Você está autenticado', 'success');

				$this->redirect($this->Auth->redirect());
			}

			$this->__setFlash('Usuário ou senha incorreto', 'attention');
		}
	}

	public function logout()
	{
		$this->__setFlash('Você saiu do sistema', 'success');

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
				return;
			}

			$this->__setFlash('Endereço de email não cadastrado', 'attention');
			return;
		}

		$this->__setFlash('Você deve informar seu endereço de email cadastrado', 'attention');
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
				$this->__setFlash('Token fornecido inválido. Verique o endereço acessado, por favor.', 'attention');
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
					$this->__setFlash('Senha atualizada. Agora você já pode fazer seu login com a nova senha.', 'success');
					$this->redirect(array('action' => 'login'));
				}

				$this->__setFlash('Falha ao atualizar senha. Tente novamente.', 'attention');
				return;
			}
		}

		$this->__setFlash('O endereço acessado não é válido.', 'attention');
		$this->redirect('/');
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

			if(isset($this->request->data['User']['password']))
				unset($this->request->data['User']['password']);

			if(isset($this->request->data['User']['password_confirm']))
				unset($this->request->data['User']['password_confirm']);

			$this->__setFlash('Não foi possível criar a conta. Verifique os dados inseridos.', 'attention');
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
				$this->__setFlash('Seu cadastro já foi verificado', 'attention');
				$this->redirect('/');
			}

			if($userData['User']['account_validation_token'] == $hash)
			{
				$userData['User']['account_validation_token'] = null;
				$userData['User']['account_validation_expires_at'] = null;
				$userData['User']['active'] = true;

				$this->User->save($userData);

				$this->__setFlash('Cadastro Verificado com Sucesso!', 'success');
				$this->redirect('/');
			}

			$this->__setFlash('Código de verificação inválido!', 'attention');
			$this->redirect('/');
		}

		$this->__setFlash('Corrija o nome de usuário e/ou código de verificação!', 'attention');
		$this->redirect('/');
	}

	/*******************
	 * Admin actions
	 ******************/

	public function admin_profile()
	{
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
			$this->__setFlash('Usuário inválido', 'attention');
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
				$this->__setFlash('Usuário adicionado', 'success');
				$this->redirect(array('action' => 'index'));
			}

			if(isset($this->request->data['User']['password']))
				unset($this->request->data['User']['password']);

			if(isset($this->request->data['User']['password_confirm']))
				unset($this->request->data['User']['password_confirm']);

			$this->request->data['User']['groups'] = json_decode($groups, true);

			$this->__setFlash('Usuário não pode ser salvo. Tente novamente, por favor.', 'attention');
		}
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->__setFlash('Usuário inválido', 'attention');
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->request->data))
		{
			$this->request->data['User']['groups'] = json_encode($this->request->data['User']['groups']);

			if ($this->User->save($this->request->data))
			{
				// se o admin está editando sua própria conta
				if($this->request->data['User']['id'] == $this->activeUser['id'])
				{
					// recarrega suas informações
					$this->__reloadUserInfo();
				}

				$this->__setFlash('Usuário salvo', 'success');
				$this->__goBack();
			}

			$this->request->data['User']['groups'] = json_decode($this->request->data['User']['groups'], true);

			$this->__setFlash('Não foi possível salvar a alteração. Tente novamente, por favor.', 'attention');
		}

		if (empty($this->request->data))
		{
			$this->request->data = $this->User->read(null, $id);
			$this->request->data['User']['groups'] = json_decode($this->request->data['User']['groups']);
		}
	}

	public function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Usuário inválido', 'attention');
			$this->redirect(array('action'=>'index'));
		}

		if ($this->User->delete($id))
		{
			$this->__setFlash('Usuário removido', 'success');
			$this->redirect(array('action'=>'index'));
		}

		$this->__setFlash('Usuário não pode ser removido', 'attention');
		$this->redirect(array('action' => 'index'));
	}

	/***************************
	 * Participant actions
	 ***************************/

	public function participant_profile()
	{
		$this->set('user', $this->activeUser['id']);
		$this->render('profile');
	}

	public function participant_edit()
	{
		if(!empty($this->request->data))
		{
			$this->request->data['User']['id'] = $this->activeUser['id'];
			$this->request->data['User']['username'] = $this->activeUser['username'];

			if($this->User->save($this->request->data))
			{
				$this->__reloadUserInfo();
				$this->__setFlash('Dados Atualizados!', 'success');
				$this->redirect('/');
			}

			$this->__setFlash('Erro ao Atualizar Dados', 'attention');
		}

		$this->request->data = $this->User->read(null, $this->activeUser['id']);
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
		$user = $this->User->read(null, $this->activeUser['id']);

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

			$email->to($userData['User']['email'])
					->subject('[' . Configure::read('Comitiva.name') . ' - Inscrições] Pedido para recuperar senha')
					->replyTo(Configure::read('Message.from'))
					->from(Configure::read('Message.from'))
					->template('reset_password')
					->emailFormat('html');

			if($email->send())
			{
				$this->__setFlash('Instruções para redefinir a senha foram enviadas para seu email cadastrado');
				return;
			}
		}

		$this->__setFlash(sprintf('Não foi possível iniciar processo para rercuperação da senha. Entre em contato através do email %s para obter ajuda', Configure::read('Message.from')), 'attention');
	}

	/**
	 * Envia um email para o usuário com os dados de sua conta
	 * não inclui senha
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

			$email->to($userData['User']['email'])
					->subject('[' . Configure::read('Comitiva.name') . ' - Inscrições] Confirmação de conta')
					->replyTo(Configure::read('Message.from'))
					->from(Configure::read('Message.from'))
					->template('account_confirm')
					->emailFormat('html');

			if($email->send())
			{
				$this->__setFlash('Foi enviado um email para confirmação da sua conta', 'attention');
				return;
			}
		}
		else
		{
			$this->User->delete($userData['User']['id']);
		}

		$this->__setFlash(sprintf(__('Não foi possível enviar o email de confirmação da conta para seu endereço. Entre em contato através do email %s para obter ajuda'), Configure::read('Message.replyTo'), 'attention');
	}
}