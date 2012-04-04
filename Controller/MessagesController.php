<?php
App::uses('Sanitize', 'Utility');
App::uses('Mailer', 'Mailer.Lib');
class MessagesController extends AppController
{
	public $helpers = array('TinyMCE.TinyMCE');

	public function admin_index()
	{
		$this->redirect(array('action' => 'sendMessage'));
	}

	public function admin_sendMessage()
	{
		// caso a mensagem tenha sido fornecida
		if(!empty($this->request->data))
		{
			$op = array(
				'from' => Configure::read('Message.from'),
				'subject' => '[' . Configure::read('Comitiva.name') . ']' . $this->request->data['Message']['subject'],
				'body' => $this->request->data['Message']['text']
			);

			// monta o campo de destinatário dependendo do tipo de mensagem
			switch(($this->request->data['Message']['to'] + $this->request->data['Message']['toFilter']))
			{
				// enviar para todos os usuários
				case 0:
					$op['to'] = $this->__getUserMailAddress();
					break;
				case 10:
					$op['to'] = $this->__getUserMailAddress($this->request->data['Message']['event_id']);
					break;
				case 11:
					$op['to'] = $this->__getUserMailAddress($this->request->data['Message']['event_id'], 1);
					break;
				case 12:
					$op['to'] = $this->__getUserMailAddress($this->request->data['Message']['event_id'], 2);
					break;
				case 13:
					$op['to'] = $this->__getUserMailAddress($this->request->data['Message']['event_id'], 3);
					break;
				case 20:
					$op['to'] = $this->__getUserMailAddress($this->request->data['Message']['event_id'], 4);
					break;
				default:
					$this->__setFlash('Opção inválida, selecione outro filtro', 'error');
					return;
			}

			// verifica se há destinatário
			if(!empty($op['to']))
			{
				$status = $this->__sendMessage($op);

				if($status === true)
				{
					$this->__setFlash('Mensagem enviada', 'success');
					$this->redirect(array('action' => 'index'));
				}

				if($status > 1)
				{
					$this->__setFlash('A mensagem não pode ser enviada a todos os destinatários');
					$this->redirect(array('action' => 'index'));
				}

				$this->__setFlash('Falha no envio', 'error');
			}

		}

		// carrega e seta a lista de eventos cadastrado para usuário selecionar
		$this->loadModel('Event');
		$this->set('events', $this->Event->getList());

		// define os tipos de mensagens suportados
		$types = array(
			0 => __('Todos os usuários'),
			10 => __('Inscritos no evento'),
			20 => __('Não inscritos no evento')
		);

		$filters = array(
			1 => __('Realizaram Check-in'),
			2 => __('Não compareceram'),
			3 => __('Não confirmaram pagamento')
		);

		$this->set(compact('types', 'filters'));
	}

	/**
	 * Envia uma mensagem, utilizando os dados setados no atributo da classe MessagesController::data
	 *
	 * @return int $status
	 *             - true em caso de sucesso
	 *             - int > 0 caso haja erro no envio para alguém
	 *             - false caso não seja possível enviar nenhuma mensagem
	 */
	protected function __sendMessage($options = array())
	{
		if(empty($options))
			return -1;

		config('email');
		$configClass = new EmailConfig();
		$config = $configClass->default;
		$transport = strtolower($config['transport']);

		if($transport !== 'smtp')
			throw new CakeException('Configuração de email não disponível', true);

		$compatibleConfig = array(
			'transport' => 'smtp',
			'smtp' => array(
				'username' => $config['username'],
				'password' => $config['password'],
				'port' => $config['port'],
				'host' => substr($config['host'], 3),
				'encryptation' => 'ssl',
			)
		);

		$mailer = new Mailer($compatibleConfig);

		if(($status = $mailer->sendMessage($options)) === 0)
			return false;

		$tos = 0;

		if(isset($options['to']))
			$tos += count($options['to']);

		if(isset($options['cc']))
			$tos += count($options['cc']);

		if(isset($options['bcc']))
			$tos += count($options['bcc']);

		return $status == $tos ? true : $status;
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