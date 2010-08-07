<?php
class PaymentsController extends AppController
{

	public $name = 'Payments';
	
	public $uses = array('Payment');
	
	public $components = array('Email');
	
	public $helpers = array('Formatacao');
	
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
			$this->goBack();
		}
		
		$this->set('payment', $this->Payment->read(null, $id));
	}

	public function admin_add($id = null)
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
		
		if($id == null)
		{
			$this->Session->setFlash(__('Inscrição inválida', TRUE));
			$this->redirect(array('action' => 'index'));
		}
		
		$subscription = $this->Payment->Subscription->read(null, $id);
		$this->set(compact('subscription'));
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Pagamento inválido', true));
			$this->goBack();
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
			$this->data = $this->Payment->Subscription->find('first', array('conditions' => array('Payment.id' => $id), 'recursive' => 2));
		}
		
		$this->set('subscription', $this->data);
		
		$subscriptions = $this->Payment->Subscription->find('list');
		$this->set(compact('subscriptions'));
	}

	public function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Id de pagamento inválido', true));
		}
		else if ($this->Payment->delete($id))
		{
			$this->Session->setFlash(__('Pagamento apagado!', true));
		}
		else
		{
			$this->Session->setFlash(__('Pagamento não foi apagado.', true));
		}
		
		$this->__goBack();
	}
	
	public function admin_confirm($id = null)
	{
		if ($id == null)
		{
			$this->Session->setFlash(__('Id de inscrição inválido', true));
			$this->__goBack();
		}
		
		// verify if this payment is already confirmed
		$verify = $this->Payment->read(null, $id);
		
		if(is_array($verify) && $verify['Payment']['confirmed'] == 1)
		{
			$this->Session->setFlash(__('Pagamento já havia sido confirmado', true));
			
			$this->__goBack();
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
			if($this->__sendConfirmationMail($id))
			{
				$this->Session->setFlash(__('Pagamento confirmado', true));
			}
			else
			{
				$this->Session->setFlash(__('Pagamento confirmado, mas aviso não pode ser enviado por email', true));
			}
		}
		else
		{
			$this->Session->setFlash(__('Não foi possível confirmar o pagamento', true));
		}
		
		$this->__goBack();
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
			
			$this->__goBack();
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
		if(isset($this->data['Subscription']['id']))
		{
			$subscription_id = $this->data['Subscription']['id'];
		}
		
		$subscription = $this->Payment->Subscription->find('first', array('conditions' => array('Subscription.id' => $subscription_id)));
		
		if ($subscription_id == null)
		{
			$this->Session->setFlash(__('Inscrição Inválida', true));
			$this->redirect(array('action' => 'index'));
		}
		// verify if subscription is the logged user
		else if($subscription['Subscription']['user_id'] != User::get('id'))
		{
			$this->Session->setFlash(__('Você não possui autorização para realizar esta ação!', true));
			$this->redirect(array('action' => 'index'));
		}
		// verify if event is free (no need payments)
		else if($subscription['Event']['free'])
		{
			$this->Session->setFlash(__('Este evento é gratuito!', true));
			$this->__goBack();
		}
		// verify if payment already exist
		else if(!empty($subscription['Payment']['id']))
		{
			$this->Session->setFlash(__('Este Pagamento Já Foi Informado!', true));
			$this->__goBack();
		} 
		
		// verify if form has submited
		if (!empty($this->data))
		{
			$this->Payment->create();
			$this->data['Payment']['subscription_id'] = $subscription_id;
			
			if ($this->Payment->save($this->data))
			{  
				$this->Session->setFlash(__('Pagamento Informado!', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('O pagamento não pôde ser registrado. Tente novamente.', true));
			}
		}
			
		$this->set(compact('subscription'));
	}
	
	/**
	 * Envia um email para o endereço associado ao usuário
	 * com informações para recuperação da senha
	 * 
	 * @param array $userData
	 * @return bool
	 */
	protected function __sendConfirmationMail($payment_id)
	{
		$paymentData = $this->Payment->Subscription->find(
			'first',
			array(
				'conditions' => array(
					'Payment.id' => $payment_id
				),
				'contains' => array(
					'Payment',
					'Subscription',
					'Event',
					'User'
				)
			)
		);

		if($paymentData)
		{
			$dt = new DateTime($paymentData['Payment']['created']);
			
			// convenience format
			$payment = array(
				'user' => $paymentData['User']['name'],
				'email' => $paymentData['User']['email'],
				'event' => $paymentData['Event']['title'],
				'date' => $dt->format('d/m/Y')
			);
			
			$this->set(compact('payment'));
			
			$this->Email->reset();

			/* Setup parameters of EmailComponent */
			$this->Email->to = $payment['email'];
			$this->Email->subject = '[PHPMS - Inscrições] Confirmação de pagamento';
			$this->Email->replyTo = 'admin.phpms@gmail.com';
			$this->Email->from = 'PHPMS <admin.phpms@gmail.com>';
			$this->Email->template = 'payment_confirm';
			$this->Email->charset = 'utf-8';

			$this->Email->sendAs = 'html';

			if($this->Email->send())
			{
				return true;
			}
		}

		return false;
	}
}
?>