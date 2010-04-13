<?php
App::import('Sanitize');

class SubscriptionsController extends AppController
{
	public $name = 'Subscriptions';
	public $uses = array('Subscription');
	
	public $helpers = array('Formatacao');
	
	public function isAuthorized()
	{
		if($this->userLogged === TRUE && $this->params['prefix'] == User::get('type'))
		{
			return true;
		}
			
		return false;
	}
	
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
		
		$this->set('subscriptions', $this->paginate());
	}

	public function admin_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Inscrição inválida.', true));
			$this->__goBack();
		}
		
		$this->set('subscription', $this->Subscription->read(null, $id));
	}

	public function admin_add()
	{
		if (!empty($this->data))
		{
			$this->Subscription->create();
			
			if ($this->Subscription->save($this->data))
			{
				$this->Session->setFlash(__('Nova inscrição  salva com sucesso!', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('A inscrição não pôde ser salva. Tente novamente.', true));
			}
		}
		
		$users = $this->Subscription->User->getList();
		$events = $this->Subscription->Event->getList();
		$this->set(compact('users', 'events'));
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Inscrição inválida', true));
			$this->__goBack();
		}
		
		if (!empty($this->data))
		{
			if ($this->Subscription->save($this->data))
			{
				$this->Session->setFlash(__('Inscrição atualizada com sucesso!', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('A inscrição não pôde ser salva. Tente novamente.', true));
			}
		}
		
		if (empty($this->data))
		{
			$this->data = $this->Subscription->find('first', array('conditions' => array('Subscription.id' => $id)));
		}
		
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	public function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Inscrição inválido!', true));
		}
		else if ($this->Subscription->delete($id))
		{
			$this->Session->setFlash(__('Inscrição apagada!', true));
		}
		else
		{
			$this->Session->setFlash(__('Inscrição não foi apagada', true));
		}
		
		$this->__goBack();
	}
	
	public function admin_checkin($id = null)
	{
		if(!$id)
		{
			$this->Session->setFlash(__('Inscrição inválido!', true));
			$this->__goBack();
		}
		
		$subscription = $this->Subscription->read(null, $id);
		
		if(!$subscription)
		{
			$this->Session->setFlash(__('Inscrição inválido!', true));
			$this->__goBack();
		}
		
		$this->Subscription->create($subscription);
		
		if($this->Subscription->saveField('checked', 1))
		{
			$this->Session->setFlash(__('Check-in realizado com sucesso!', true));
		}
		else
		{
			$this->Session->setFlash(__('Falha no check-in.', true));
		}
		
		$this->__goBack();
	}
	
	/*
	 * Ações para rota de participantes
	 */
	public function participant_index()
	{
		$this->Subscription->recursive = 0;
		$this->set('subscriptions', $this->paginate(array('user_id' => User::get('id'))));
	}

	public function participant_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Inscrição inválida', true));
			$this->__goBack();
		}
		
		$this->set('subscription', $this->Subscription->find(
			'first',
			array(
				'conditions' => array(
					'Subscription.id' => $id,
					'Subscription.user_id' => User::get('id')
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
		if (!empty($this->data))
		{
			if($this->data['Subscription']['confirm'] != sha1($event_id))
			{
				$this->Session->setFlash(__('A inscrição não pôde ser feita. Verifique se o evento ainda está disponível.', true));
				$this->redirect(array('action' => 'index'));
			}
			
			// verifica se o evento é mesmo válido
			if($this->Subscription->Event->read(null,$event_id) == NULL)
			{
				//caso não seja saí da inscrição
				$this->Session->setFlash(__('A inscrição não pôde ser feita. Evento inválido.', true));
				$this->redirect(array('action' => 'index'));
			}
			
			$this->Subscription->create();
			
			$this->data['Subscription']['event_id'] = $event_id;
			$this->data['Subscription']['user_id'] = User::get('id');
			
			if ($this->Subscription->save($this->data))
			{
				$this->Session->setFlash(__('Sua inscrição no evento foi efetuada!', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('A inscrição não pôde ser feita. Tente novamente.', true));
				$this->redirect(array('action' => 'index'));
			}
		}
		
		if($event_id != null)
		{
			$subscription = $this->Subscription->find('first', array('recursive' => -1, 'conditions' => array('event_id' => $event_id, 'user_id' => User::get('id'))));
			
			if(!empty($subscription))
			{
				$this->Session->setFlash(__('Sua inscrição neste evento já foi efetuada!', true));
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
			$this->Session->setFlash(__('Inscrição inválido!', true));
			$this->__goBack();
		}
		
		$subscription = $this->Subscription->find('first', array('recursive' => -1, 'conditions' => array('event_id' => $id, 'user_id' => User::get('id'))));
		
		// verifica se a inscrição está registrada para o usuário logado
		if(!empty($subscription))
		{
			// caso não esteja somente seta a mensagem de erro
			$this->Session->setFlash(__('Inscrição inválida.', true));
		}
		// caso contrário tenta excluir a inscrição
		else if ($this->Subscription->delete($id))
		{
			// se for excluída, define mensagem de sucesso
			$this->Session->setFlash(__('Inscriçao apagada!', true));
		}
		else
		{
			// caso contrário define mensagem de falha
			$this->Session->setFlash(__('Inscrição não foi apagada', true));
		}
		
		$this->__goBack();
	}
}
?>