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
	public function admin_index()
	{
		$this->Subscription->recursive = 0;
		$this->set('subscriptions', $this->paginate());
	}

	public function admin_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Inscrição inválida.', true));
			$this->redirect(array('action' => 'index'));
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
		
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Inscrição inválida', true));
			$this->redirect(array('action' => 'index'));
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
			$this->data = $this->Subscription->read(null, $id);
		}
		
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	public function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Id de inscrição inválido!', true));
			$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Subscription->del($id))
		{
			$this->Session->setFlash(__('Inscrição apagada!', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Inscrição não foi apagada', true));
		$this->redirect(array('action' => 'index'));
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
			$this->redirect(array('action' => 'index'));
		}
		
		$this->set('subscription', $this->Subscription->read(null, $id));
	}

	public function participant_add($event_id = null)
	{
		if (!empty($this->data))
		{
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
			$subscription = $this->Subscription->find('first', array('conditions' => array('event_id' => $event_id)));
			
			if(!empty($subscription))
			{
				$this->Session->setFlash(__('Sua inscrição neste evento já foi efetuada!', true));
				$this->redirect(array('action' => 'index'));
			}
			
			$event = $this->Subscription->Event->read(null,$event_id);
			$this->set(compact( 'event'));
		}
	}

	public function participant_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Inscrição inválida', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data))
		{
			if ($this->Subscription->save($this->data))
			{
				$this->Session->setFlash(__('Inscrição Salva!', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('A inscrição não pôde ser salva. Tente novamente.', true));
			}
		}
		
		if (empty($this->data))
		{
			$this->data = $this->Subscription->read(null, $id);
		}
		
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	public function participant_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Id de inscrição inválido!', true));
			$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Subscription->del($id))
		{
			$this->Session->setFlash(__('Inscriçao apagada!', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Inscrição não foi apagada', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>