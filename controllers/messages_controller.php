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
			$op = array(
				'from' => Configure::read('Message.from'),
				'to' => $this->__getUserMailAddress($this->data['Message']['event_id']),
				'subject' => $this->data['Message']['subject'],
				'body' => $this->data['Message']['text']
			);
			
			switch($this->sendMessage($op))
			{
				case 0:
					$this->Session->setFlash(__('Convite enviado', TRUE));
					$this->redirect(array('action' => 'index'));
					break;
				case 1:
					$this->Session->setFlash(__('Convite não pode ser enviado a todos os destinatários', TRUE));
					$this->redirect(array('action' => 'index'));
					break;
				case -1:
					$this->Session->setFlash(__('Falha no envio', TRUE));
					break;
			}
		}
		
		// carrega e seta a lista de eventos cadastrado para usuário selecionar
		$this->loadModel('Event');
		$this->set('events', $this->Event->find('list'));
	}
	
	/**
	 * Envia uma mensagem, utilizando os dados setados no atributo da classe MessagesController::data
	 * 
	 * @return int $status - 0 em caso de sucesso, 1 caso haja erro no envio para alguém e -1 caso não seja possível enviar nenhuma mensagem
	 */
	protected function sendMessage($options = array())
	{
		if($this->Mailer->sendMessage($options))
		{
			if(empty($this->Mailer->failures))
				return 0;
			else
			{
				$this->__saveFailedMailer($this->Mailer->failures);
				return 1;
			}
		}
		else
			return -1;
	}
	
	/**
	 * Este método deverá tratar os destinatários que não puderam receber a mensagem
	 * 
	 * @param array $mails
	 * @return void
	 */
	protected function __saveFailedMailer($mails = array())
	{
		
	}
	
	private function __getUserMailAddress($event_id, $subscribeds = false)
	{
		$condition = null;
		
		if(!$subscribeds)
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
				$userIds = '';
				
				foreach($notIn as $user)
				{
					$userIds .= $user['Subscription']['user_id'] . ',';
				}
				
				$userIds = substr($userIds, 0, -1);
				
				$condition = "User.id NOT IN({$userIds})";
			}
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
		
		$out = array();
		
		foreach($receivers as $receiver)
		{
			$out[] = $receiver['User']['email'];
		}
		
		return $out;
	}
}