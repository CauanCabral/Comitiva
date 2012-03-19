<?php
class PaymentsController extends AppController
{

	public $name = 'Payments';

	public $uses = array('Payment');

	public $components = array('Email');

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
			$this->__setFlash('Pagamento inválido', 'error');
			$this->goBack();
		}

		$this->set('payment', $this->Payment->read(null, $id));
	}

	public function admin_add($id = null)
	{
		if (!empty($this->request->data))
		{
			$this->Payment->create();
			if ($this->Payment->save($this->request->data))
			{
				$this->__setFlash('Novo pagamento efetuado!', 'sucess');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('O pagamento não pôde ser salvo. Tente novamente.', 'attention');
		}

		if($id == null)
		{
			$this->__setFlash('Inscrição inválida', 'error');
			$this->redirect(array('action' => 'index'));
		}

		$subscription = $this->Payment->Subscription->read(null, $id);
		$this->set(compact('subscription'));
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->__setFlash('Pagamento inválido', 'error');
			$this->goBack();
		}

		if (!empty($this->request->data))
		{
			if ($this->Payment->save($this->request->data))
			{
				$this->__setFlash('Pagamento atualizado!', 'success');
				$this->redirect(array('action' => 'index'));
			}
			
			$this->__setFlash('O pagamento não pôde ser atualizado. Tente novamente.', 'attention');
		}

		if (empty($this->request->data))
		{
			$this->request->data = $this->Payment->Subscription->find('first', array('conditions' => array('Payment.id' => $id), 'recursive' => 2));
		}

		$this->set('subscription', $this->request->data);

		$subscriptions = $this->Payment->Subscription->find('list');
		$this->set(compact('subscriptions'));
	}

	public function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Id de pagamento inválido', 'error');
		}
		else if ($this->Payment->delete($id))
		{
			$this->__setFlash('Pagamento apagado!', 'success');
		}
		else
		{
			$this->__setFlash('Pagamento não foi apagado.', 'error');
		}

		$this->__goBack();
	}

	public function admin_confirm($id = null)
	{
		if ($id == null)
		{
			$this->__setFlash('Id de inscrição inválido', 'error');
			$this->__goBack();
		}

		$verify = $this->Payment->read(null, $id);

		if(is_array($verify) && $verify['Payment']['confirmed'] == 1)
		{
			$this->__setFlash('Pagamento já havia sido confirmado', 'attention');
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
				$this->__setFlash('Pagamento confirmado', 'success');
			}
			else
			{
				$this->__setFlash('Pagamento confirmado, mas aviso não pode ser enviado por email', 'attention');
			}
		}
		else
		{
			$this->__setFlash(_'Não foi possível confirmar o pagamento', 'error');
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
				'Subscription.user_id' => $this->activeUser['id']
			)
		);

		$this->set('payments', $this->paginate());
	}

	public function participant_view($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Pagamento inválido', 'error');
			$this->__goBack();
		}

		$this->set('payment', $this->Payment->find(
			'first',
			array(
				'conditions' => array(
					'Payment.id' => $id,
					'Subscription.user_id' => $this->activeUser['id']
					)
				)
			)
		);
	}

	public function participant_add($subscription_id = null)
	{
		if(isset($this->request->data['Subscription']['id']))
		{
			$subscription_id = $this->request->data['Subscription']['id'];
		}

		$subscription = $this->Payment->Subscription->find('first', array('conditions' => array('Subscription.id' => $subscription_id)));

		if ($subscription_id == null)
		{
			$this->__setFlash('Inscrição Inválida', 'error');
			$this->redirect(array('action' => 'index'));
		}
		
		if($subscription['Subscription']['user_id'] != $this->activeUser['id'])
		{
			$this->__setFlash('Você não possui autorização para realizar esta ação!', 'attention');
			$this->redirect(array('action' => 'index'));
		}
		
		if($subscription['Event']['free'])
		{
			$this->__setFlash('Este evento é gratuito!', 'success');
			$this->__goBack();
		}
		
		if(!empty($subscription['Payment']['id']))
		{
			$this->__setFlash('Este pagamento já foi informado!', 'attention');
			$this->__goBack();
		}

		if (!empty($this->request->data))
		{
			$this->Payment->create();
			$this->request->data['Payment']['subscription_id'] = $subscription_id;

			if ($this->Payment->save($this->request->data))
			{
				$this->__setFlash('Pagamento Informado!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('O pagamento não pôde ser registrado. Tente novamente.', 'attention');
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

			$payment = array(
				'user' => $paymentData['User']['name'],
				'email' => $paymentData['User']['email'],
				'event' => $paymentData['Event']['title'],
				'date' => $dt->format('d/m/Y')
			);

			$this->set(compact('payment'));
			$sub = '[' . Configure::read('Comitiva.name') . ' - Inscrições] Confirmação de pagamento';

			if($this->__sendMailNotification($payment['email'], $sub, 'payment_confirm'))
			{
				return true;
			}
		}

		return false;
	}
}