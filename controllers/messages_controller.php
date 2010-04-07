<?php
App::import('CORE', 'Sanitize');

class MessagesController extends AppController
{
	public $uses = array('Message');
	
	public $components = array('Mailer.Mailer');
	
	public $helpers = array('TinyMce.TinyMce');

	public function isAuthorized()
	{
		if($this->userLogged == TRUE && $this->params['prefix'] == User::get('type'))
		{
			return true;
		}
		
		return false;
	}
	
	public function admin_index() {}
	
	public function admin_sendInvitation()
	{
		// caso a mensagem tenha sido fornecida
		if(!empty($this->data))
		{
			$this->loadModel('Subscription');
			
			$notIn = $this->Subscription->find(
				'all',
				array(
					'fields' => array('Subscription.user_id'),
					'conditions' => array(
						'Subscription.event_id' => $this->data['Message']['event_id']
					),
					'recursive' => -1
				)
			);
			
			if(!empty($notIn))
			{
				$notIn = explode(',', $notIn);
				$condition = "User.id NOT IN({$notIn})";
			}
			else
			{
				$condition = null;
			}
			
			$this->loadModel('User');
			
			$receivers = $this->User->find(
				'all',
				array(
					'fields' => array(
						'User.fullName',
						'User.email'
					),
					'conditions' => array(
						$condition,
						'User.active' => 1
					),
					'recursive' => -1
				)
			);
			
			$op = array(
				'from' => 'cauan@radig.com.br',
				'to' => 'cauanc@gmail.com',
				'subject' => $this->data['Message']['subject'],
				'body' => $this->data['Message']['message']
			);
			
			if($this->Mailer->sendMessage($op))
			{
				$this->Session->setFlash(__('Convite enviado', TRUE));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Falha no envio', TRUE));
			}
		}
		
		// carrega e seta a lista de eventos cadastrado para usuário selecionar
		$this->loadModel('Event');
		$this->set('events', $this->Event->find('list'));
	}
	
	/**
	 * Envia uma mensagem, utilizando os dados setados no atributo da classe MessagesController::data
	 * 
	 * @return unknown_type
	 */
	protected function sendMessage()
	{
		
	}
}