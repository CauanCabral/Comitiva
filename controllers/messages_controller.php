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
	
	public function admin_index()
	{
		$this->redirect(array('action' => 'sendMessage'));
	}
	
	public function admin_sendMessage()
	{
		// caso a mensagem tenha sido fornecida
		if(!empty($this->data))
		{
			$op = array(
				'from' => Configure::read('Message.from'),
				'subject' => '[Comitiva] ' . $this->data['Message']['subject'],
				'body' => $this->data['Message']['text']
			);
			
			// monta o campo de destinatário dependendo do tipo de mensagem
			switch($this->data['Message']['type'])
			{
				case 0:
					$op['to'] = $this->__getUserMailAddress();
					break;
				case 1:
					$op['to'] = $this->__getUserMailAddress($this->data['Message']['event_id'], true);
					break;
				case 2:
					$op['to'] = $this->__getUserMailAddress($this->data['Message']['event_id']);
					break;
			}
			
			// trata o retorno do envio
			switch($this->__sendMessage($op))
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
		$this->set('events', $this->Event->find(
			'list',
			array(
				'conditions' => array(
					'OR' => array(
						'Event.parent_id ' => 0,
						'Event.parent_id IS NULL'
						)
					)
				)
			)
		);
		
		// define os tipos de mensagens suportados
		$types = array(
			0 => __('Todos os cadastrados', TRUE),
			1 => __('Usuários inscritos no evento', TRUE),
			2 => __('Usuários não inscritos', TRUE)
		);
		$this->set('types', $types);
	}
	
	/**
	 * Envia uma mensagem, utilizando os dados setados no atributo da classe MessagesController::data
	 * 
	 * @return int $status - 0 em caso de sucesso, 1 caso haja erro no envio para alguém e -1 caso não seja possível enviar nenhuma mensagem
	 */
	protected function __sendMessage($options = array())
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
		//TODO
	}
	
	private function __getUserMailAddress($event_id = NULL, $subscribeds = FALSE)
	{
		$conditions = array('User.active' => 1);
		
		// seleciona usuários que não estão inscritos em um determinado evento
		if($event_id !== NULL && !$subscribeds)
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
				
				$conditions[] = "User.id NOT IN({$userIds})";
			}
		}
		// seleciona usuários que estão inscritos em um determinado evento
		else if($event_id !== NULL && $subscribeds)
		{
			$this->loadModel('Subscription');
			
			$in = $this->Subscription->find(
				'all',
				array(
					'fields' => array('Subscription.user_id'),
					'conditions' => array(
						'Subscription.event_id' => $this->data['Message']['event_id']
					),
					'recursive' => -1
				)
			);
		
			if(!empty($in))
			{
				$userIds = '';
				
				foreach($in as $user)
				{
					$userIds .= $user['Subscription']['user_id'] . ',';
				}
				
				$userIds = substr($userIds, 0, -1);
				
				$conditions[] = "User.id IN({$userIds})";
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
				'conditions' => $conditions,
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