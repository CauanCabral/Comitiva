<?php
App::import('CORE', 'Sanitize');

class MessagesController extends AppController
{
	public $uses = array('Message');
	
	public $components = array('Mailer.Mailer');
	
	public $helpers = array('TinyMce.TinyMce');
	
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
			switch(($this->data['Message']['to'] + $this->data['Message']['toFilter']))
			{
				// enviar para todos os usuários
				case 0:
					$op['to'] = $this->__getUserMailAddress();
					break;
				case 10:
					$op['to'] = $this->__getUserMailAddress($this->data['Message']['event_id']);
					break;
				case 11:
					$op['to'] = $this->__getUserMailAddress($this->data['Message']['event_id'], 1);
					break;
				case 12:
					$op['to'] = $this->__getUserMailAddress($this->data['Message']['event_id'], 2);
					break;
				case 13:
					$op['to'] = $this->__getUserMailAddress($this->data['Message']['event_id'], 3);
					break;
				case 20:
					$op['to'] = $this->__getUserMailAddress($this->data['Message']['event_id'], 4);
					break;
				default:
					$this->Session->setFlash(__('Opção inválida, selecione outro filtro', TRUE));
					return;
			}
			
			// verifica se há destinatário
			if(!empty($op['to']))
			{
				// trata o retorno do envio
				switch($this->__sendMessage($op))
				{
					case 0:
						$this->Session->setFlash(__('Mensagem enviada', TRUE));
						$this->redirect(array('action' => 'index'));
						break;
					case 1:
						$this->Session->setFlash(__('A mensagem não pode ser enviada a todos os destinatários', TRUE));
						$this->redirect(array('action' => 'index'));
						break;
					case -1:
						$this->Session->setFlash(__('Falha no envio', TRUE));
						break;
				}
			}
			
		}
		
		// carrega e seta a lista de eventos cadastrado para usuário selecionar
		$this->loadModel('Event');
		$this->set('events', $this->Event->getList());
		
		// define os tipos de mensagens suportados
		$types = array(
			0 => __('Todos os usuários', TRUE),
			10 => __('Inscritos no evento', TRUE),
			20 => __('Não inscritos no evento', TRUE)
		);
		
		$filters = array(
			1 => __('Realizaram Check-in', TRUE),
			2 => __('Não compareceram', TRUE),
			3 => __('Não confirmaram pagamento', TRUE)
		);
		
		$this->set(compact('types', 'filters'));
	}
	
	/**
	 * Envia uma mensagem, utilizando os dados setados no atributo da classe MessagesController::data
	 * 
	 * @return int $status - 0 em caso de sucesso, 1 caso haja erro no envio para alguém e -1 caso não seja possível enviar nenhuma mensagem
	 */
	protected function __sendMessage($options = array())
	{
		if(empty($options))
			return -1;
		
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
	
	/**
	 * Método que busca e retorna um array com endereço de email dos usuários sob um determinado
	 * critério
	 * 
	 * $option aceita os seguintes valores
	 *  NULL: valor padrão, depende do valor de $event_id
	 *  1	: seleciona usuários que fizeram check-in no evento
	 *  2	: seleciona usuários que não fizeram check-in
	 *  3	: seleciona usuários que não confirmaram pagamento
	 *  4	: seleciona usuários que não estão inscritos no evento
	 * 
	 * @param $event_id
	 * @param $option
	 * @return array emails
	 */
	private function __getUserMailAddress($event_id = NULL, $option = NULL)
	{
		$this->loadModel('User');
		
		// condição inicial
		$conditions = array('User.active' => 1);
		
		// seleciona usuários que não estão inscritos em um determinado evento
		if($event_id !== NULL)
		{
			if($option != 4)
			{
				// usuários inscritos no evento
				$conditions[] = array('Subscription.event_id' => $event_id);
				
				switch($option)
				{
					// todos os usuários que fizeram check-in
					case 1:
						$conditions[] = array('Subscription.checked' => TRUE);
						break;
					// usuários que faltaram o evento
					case 2:
						$conditions[] = array('Subscription.checked' => FALSE);
						break;
					// usuários que não confirmaram o pagamento
					case 3:
						$conditions[] = array('Payments.confirmed' => FALSE);
						break;
				}
				
				$receivers = $this->User->Subscription->find(
					'all',
					array(
						'fields' => array(
							'User.email'
						),
						'conditions' => $conditions,
						'recursive' => 2
					)
				);
				
			}
			// usuários não inscritos no evento
			else
			{	
				// busca os usuários inscritos no evento
				$notIn = $this->User->Subscription->find(
					'all',
					array(
						'fields' => array('Subscription.user_id'),
						'conditions' => array(
							'Subscription.event_id' => $event_id
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
					
					// adiciona regra para remover usuários inscritos
					$conditions[] = "User.id NOT IN({$userIds})";
				}
				
				$receivers = $this->User->find(
					'all',
					array(
						'fields' => array(
							'User.email'
						),
						'conditions' => $conditions,
						'recursive' => -1
					)
				);
			}
		}
		// seleciona todos os usuários
		else
		{
			$receivers = $this->User->find(
				'all',
				array(
					'conditions' => $conditions,
					'recursive' => -1
				)
			);
		}
				
		// formata a saída
		$out = array();
		
		foreach($receivers as $receiver)
		{
			$out[] = $receiver['User']['email'];
		}
		
		// retorna um array de emails
		return $out;
	}
}