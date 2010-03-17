<?php
class PaymentsController extends AppController
{

	public $name = 'Payments';
	
	public $uses = array('Payment');
	
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
		$this->Payment->recursive = 0;
		
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
	
	/*
	 * Ações para rota de participante
	 */
	public function index()
	{
		$this->Payment->recursive = 0;
		$this->set('payments', $this->paginate());
	}

	public function view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Pagamento inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->set('payment', $this->Payment->read(null, $id));
	}

	public function add($subscription_id = null)
	{
		pr($this->data);
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
		$payment = $this->Payment->find('first',array('conditions' => array(
			'subscription_id' => $subscription_id,
		)));
		
		$subscription = $this->Payment->Subscription->read(null, $subscription_id);
		if(!empty($payment))
		{
			$this->Session->setFlash(__('Este Pagamento Já Foi Informado!', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if(!isset($subscription_id))
		{
			$this->Session->setFlash(__('Pagamento Inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('subscription'));
	}
}
?>