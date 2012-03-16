<?php
App::import('Sanitize');

class SubscriptionsController extends AppController
{
	public $name = 'Subscriptions';
	public $uses = array('Subscription');
	
	public $helpers = array('Csv');
	
	/*
	 * Ações para rota administrativa
	 */
	public function admin_index($event_id = null)
	{
		$this->Subscription->recursive = 0;
		
		if(is_numeric($event_id))
		{
			$this->paginate = array(
				'conditions' => array(
					'event_id' => $event_id
				)
			);
		}
		
		$this->set(compact('event_id'));
		$this->set('subscriptions', $this->paginate());
	}

	public function admin_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Inscrição inválida.'), 'default', array('class' => 'attention'));
			$this->__goBack();
		}
		
		$this->set('subscription', $this->Subscription->read(null, $id));
	}

	public function admin_add()
	{
		if (!empty($this->request->data))
		{
			$this->Subscription->create();
			
			if ($this->Subscription->save($this->request->data))
			{
				$this->Session->setFlash(__('Nova inscrição  salva com sucesso!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('A inscrição não pôde ser salva. Tente novamente.'), 'default', array('class' => 'attention'));
			}
		}
		
		$users = $this->Subscription->User->getList();
		$events = $this->Subscription->Event->getList();
		$this->set(compact('users', 'events'));
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->Session->setFlash(__('Inscrição inválida'), 'default', array('class' => 'attention'));
			$this->__goBack();
		}
		
		if (!empty($this->request->data))
		{
			if ($this->Subscription->save($this->request->data))
			{
				$this->Session->setFlash(__('Inscrição atualizada com sucesso!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('A inscrição não pôde ser salva. Tente novamente.'), 'default', array('class' => 'attention'));
			}
		}
		
		if (empty($this->request->data))
		{
			$this->request->data = $this->Subscription->find('first', array('conditions' => array('Subscription.id' => $id)));
		}
		
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	public function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Inscrição inválido!'), 'default', array('class' => 'attention'));
		}
		else if ($this->Subscription->delete($id))
		{
			$this->Session->setFlash(__('Inscrição removida!'), 'default', array('class' => 'success'));
		}
		else
		{
			$this->Session->setFlash(__('Inscrição não foi removida'), 'default', array('class' => 'attention'));
		}
		
		$this->__goBack();
	}
	
	public function admin_checkin($id = null)
	{
		if(!$id)
		{
			$this->Session->setFlash(__('Inscrição inválido!'), 'default', array('class' => 'attention'));
			$this->__goBack();
		}
		
		$subscription = $this->Subscription->read(null, $id);
		
		if(!$subscription)
		{
			$this->Session->setFlash(__('Inscrição inválido!'), 'default', array('class' => 'attention'));
			$this->__goBack();
		}
		
		$this->Subscription->create($subscription);
		
		if($this->Subscription->saveField('checked', 1))
		{
			$this->Session->setFlash(__('Check-in realizado com sucesso!'), 'default', array('class' => 'success'));
		}
		else
		{
			$this->Session->setFlash(__('Falha no check-in.'), 'default', array('class' => 'attention'));
		}
		
		$this->__goBack();
	}
	
	public function admin_getCsv($event_id)
	{
		$this->layout = 'ajax';
		
		$fields = array('Nome', 'Sobrenome', 'Email', 'Data de Nascimento', 'CPF', 'Endereço', 'Cidade', 'Estado', 'Telefone');
		$users = $this->Subscription->find(
			'all',
			array(
				'conditions' => array(
					'Subscription.event_id' => $event_id,
					'Subscription.checked' => TRUE
					),
				'fields' => array(
						'User.name',
						'User.nickname',
						'User.email',
						'User.birthday',
						'User.cpf',
						'User.address',
						'User.city',
						'User.state',
						'User.phone'
					),
				'recursive' => 0
				)
			);
		
		$this->set(compact('users', 'fields'));
	}
	
	/*
	 * Ações para rota de participantes
	 */
	public function participant_index()
	{
		$this->Subscription->recursive = 0;
		$this->set('subscriptions', $this->paginate(array('user_id' => $this->activeUser['id'])));
	}

	public function participant_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Inscrição inválida'), 'default', array('class' => 'attention'));
			$this->__goBack();
		}
		
		$this->set('subscription', $this->Subscription->find(
			'first',
			array(
				'conditions' => array(
					'Subscription.id' => $id,
					'Subscription.user_id' => $this->activeUser['id']
					)
				)
			)
		);
	}

	/**
	 * Participante se inscreve em um evento
	 * 
	 * @param int $event_id
	 * @return void
	 */
	public function participant_add($event_id = null)
	{
		if (!empty($this->request->data))
		{
			if($this->request->data['Subscription']['confirm'] != sha1($event_id))
			{
				$this->Session->setFlash(__('A inscrição não pôde ser realizada. Verifique se o evento ainda está disponível.'), 'default', array('class' => 'attention'));
				$this->redirect(array('action' => 'index'));
			}
			
			// verifica se o evento é mesmo válido
			if($this->Subscription->Event->read(null, $event_id) === false || !$this->Subscription->Event->openToSubscription($event_id))
			{
				//caso não seja saí da inscrição
				$this->Session->setFlash(__('A inscrição não pôde ser realizada. O evento não existe ou as inscrições foram encerradas.'), 'default', array('class' => 'attention'));
				$this->redirect(array('action' => 'index'));
			}
			
			$this->Subscription->create();
			
			$this->request->data['Subscription']['event_id'] = $event_id;
			$this->request->data['Subscription']['user_id'] = $this->activeUser['id'];
			
			if ($this->Subscription->save($this->request->data))
			{
				$this->Session->setFlash(__('Sua inscrição no evento foi efetuada!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('A inscrição não pôde ser realizada. Tente novamente.'), 'default', array('class' => 'attention'));
				$this->redirect(array('action' => 'index'));
			}
		}
		
		if($event_id != null)
		{
			$subscription = $this->Subscription->find('first', array('recursive' => -1, 'conditions' => array('event_id' => $event_id, 'user_id' => $this->activeUser['id'])));
			
			if(!empty($subscription))
			{
				$this->Session->setFlash(__('Sua inscrição neste evento já foi efetuada!'));
				$this->__goBack();
			}
			
			$event = $this->Subscription->Event->read(null,$event_id);
			$this->set(compact('event'));
		}
	}

	public function participant_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Inscrição inválido!'), 'default', array('class' => 'attention'));
			$this->__goBack();
		}
		
		$subscription = $this->Subscription->find('first', array('recursive' => -1, 'conditions' => array('event_id' => $id, 'user_id' => $this->activeUser['id'])));
		
		// verifica se a inscrição está registrada para o usuário logado
		if(!empty($subscription))
		{
			// caso não esteja somente seta a mensagem de erro
			$this->Session->setFlash(__('Inscrição inválida.'), 'default', array('class' => 'attention'));
		}
		// caso contrário tenta excluir a inscrição
		else if ($this->Subscription->delete($id))
		{
			// se for excluída, define mensagem de sucesso
			$this->Session->setFlash(__('Inscriçao removida!'), 'default', array('class' => 'success'));
		}
		else
		{
			// caso contrário define mensagem de falha
			$this->Session->setFlash(__('Inscrição não foi removida'), 'default', array('class' => 'attention'));
		}
		
		$this->__goBack();
	}
}
?>