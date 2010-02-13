<?php
class UsersController extends AppController
{

	public $name = 'Users';
	
	public function isAuthorized()
	{
		if($this->loggedUser === TRUE && $this->params['prefix'] == User::get('type'))
		{
			return true;
		}
		
		return false;
	}
	
	public function login()
	{
		if($this->Auth->login())
		{
			$this->Session->setFlash(__('Você está autenticado', 1));
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

	public function profile()
	{	
		$this->set('user', User::get());
	}
	
	public function admin_index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	public function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
	}

	public function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	/***************************
	 * Auxiliar methods
	 **************************/
	
	protected function __sendLinkToMail($userData)
	{
		$secureHash = sha1($userData['User']['password'] . time());

		$success = $this->User->save(
			array(
				'User' => array(
					'id' => $userData['User']['id'],
					'reset' => $secureHash
				)
			)
		);

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
				$this->Session->setFlash('Instruções para resetar a senha foram enviadas para seu email cadastrado.');
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
}
?>