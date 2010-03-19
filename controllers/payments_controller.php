<?php
class PaymentsController extends AppController
{

	public $name = 'Payments';
	
	public $uses = array('Payment');
	
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
		$this->Payment->recursive = 2;
		
		$this->set('payments', $this->paginate());
	}

	public function admin_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Pagamento inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->set('payment', $this->Payment->read(null, $id));
	}

	public function admin_add()
	{
		if (!empty($this->data))
		{
			$this->Payment->create();
			if ($this->Payment->save($this->data))
			{
				$this->Session->setFlash(__('Novo pagamento efetuado!', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('O pagamento não pôde ser salvo. Tente novamente.', true));
			}
		}
		$subscriptions = $this->Payment->Subscription->find('list');
		$this->set(compact('subscriptions'));
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Pagamento inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data))
		{
			if ($this->Payment->save($this->data))
			{
				$this->Session->setFlash(__('Pagamento atualizado!', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('O pagamento não pôde ser atualizado. Tente novamente.', true));
			}
		}
		
		if (empty($this->data))
		{
			$this->data = $this->Payment->read(null, $id);
		}
		
		$subscriptions = $this->Payment->Subscription->find('list');
		$this->set(compact('subscriptions'));
	}

	public function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Id de pagamento inválido', true));
			$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Payment->del($id))
		{
			$this->Session->setFlash(__('Pagamento apagado!', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Pagamento não foi apagado.', true));
		$this->redirect(array('action' => 'index'));
	}
	
	public function admin_confirm($id = null)
	{
		if ($id == null)
		{
			$this->Session->setFlash(__('Id de inscrição inválido', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$success = $this->Payment->save(
			array(
				'Payment' => array(
					'id' => $id,
					'confirmed' => 1
				)
			)
		);
		
		if($success)
		{
			$this->Session->setFlash(__('Pagamento confirmado', true));
		}
		else
		{
			$this->Session->setFlash(__('Não foi possível confirmar o pagamento', true));
		}
		
		$this->redirect(array('action'=>'index'));
	}
	
	/*
	 * Ações para rota de participante
	 */
	public function participant_index()
	{
		$this->Payment->recursive = 2;
		
		$this->paginate = array(
			'conditions' => array(
				'Subscription.user_id' => User::get('id')
			)
		);
		
		$this->set('payments', $this->paginate());
	}

	public function participant_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Pagamento inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->set('payment', $this->Payment->find(
			'first',
			array(
				'conditions' => array(
					'Payment.id' => $id,
					'Subscription.user_id' => User::get('id')
					)
				)
			)
		);
	}

	public function participant_add($subscription_id = null)
	{
		// verify if event is free (no need payments)
		$subscription = $this->Payment->Subscription->read(null, $subscription_id);
		if($subscription['Event']['free'])
		{
			$this->Session->setFlash(__('Este evento é gratuito!', true));
			$this->redirect(array('action' => 'index'));
		}
		
		// verify if payment already has been saved
		$payment = $this->Payment->find(
			'first',
			array(
				'conditions' => array(
					'subscription_id' => $subscription_id,
					'Subscription.user_id' => User::get('id')
				)
			)
		);
		if(!empty($payment))
		{
			$this->Session->setFlash(__('Este Pagamento Já Foi Informado!', true));
			$this->redirect(array('action' => 'index'));
		}
		
		// verify if form has submited
		if (!empty($this->data))
		{
			$this->Payment->create();
			$this->data['Payment']['subscription_id'] = $this->data['Subscription']['id'];
			if ($this->Payment->save($this->data))
			{
				$this->Session->setFlash(__('Pagamento Informado!', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('O pagamento não pôde ser registrado. Tente novamente.', true));
				$this->redirect(array('action' => 'index'));
			}
		}
		
		// else verify if not setted id
		if(!isset($subscription_id))
		{
			$this->Session->setFlash(__('Pagamento Inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->set(compact('subscription'));
	}
}
?>