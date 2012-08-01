<?php
App::uses('AppController', 'Controller');
App::uses('Checkout', 'PagSeguro/Controller/Component');
App::uses('Notifications', 'PagSeguro/Controller/Component');
App::uses('Consult', 'PagSeguro/Controller/Component');

class PaymentsController extends AppController
{

	public $name = 'Payments';

	public $uses = array('Payment');

	public $components = array(
		'Email',
		'PagSeguro.Checkout',
        'PagSeguro.Notifications',
        'PagSeguro.Consult'
    );

    public function beforeFilter()
    {
        parent::beforeFilter();

        if(in_array($this->request->params['action'], array('notification', 'returning'))) {
            $this->Auth->allow();
        }
    }

	/*
	 * Ações para rota administrativa
	 */
	public function admin_index()
	{
		$this->Payment->recursive = 2;
		$order = array('order' => array('Payment.event_id' => 'desc', 'Payment.id' => 'desc'));
		$this->paginate = array_merge($order, $this->paginate);

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

			$this->__setFlash('O pagamento não pôde ser salvo. Tente novamente.');
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

			$this->__setFlash('O pagamento não pôde ser atualizado. Tente novamente.');
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
			$this->__setFlash('Pagamento já havia sido confirmado');
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
				$this->__setFlash('Pagamento confirmado, mas aviso não pode ser enviado por email');
			}
		}
		else
		{
			$this->__setFlash('Não foi possível confirmar o pagamento', 'error');
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

	public function participant_renew($id)
	{
		$this->Payment->id = $id;

		if(!$this->Payment->exists()) {
			throw new NotFoundException("Pagamento não encontrado");
		}

		$data = $this->Payment->find('first', array('conditions' => array('Payment.id' => $id), 'contain' => array('Subscription', 'Subscription.Event')));

		if($data['Subscription']['user_id'] != $this->activeUser['id']) {
			$this->__setFlash('Você não possui autorização para realizar esta ação!', 'error');
			$this->redirect(array('action' => 'index'));
		}

		$this->Payment->delete($id);

		$this->Payment->Subscription->id = $data['Subscription']['id'];
		$payment = $this->Payment->Subscription->buildPaymentParams($data['Subscription']['Event'], $this->activeUser, $data['Subscription']['event_price_id']);
		$name = substr($this->activeUser['name'] . ' ' . $this->activeUser['nickname'], 0, 50);

		$this->Checkout->setReference($payment['reference']);
		unset($payment['reference']);
		$this->Checkout->setItem($payment['item']);
		unset($payment['item']);
		$this->Checkout->setCustomer($this->activeUser['email'], $name);
		unset($payment['sender']);

		$this->Checkout->config($payment);
		$response = $this->Checkout->finalize(false);

		if(isset($response['checkout'])) {
			$msg = __("Sua inscrição no evento foi efetuada com sucesso!\nIremos agora redirecionar você para o PagSeguro, onde será possível pagar sua inscrição.");
			$this->flash($msg, $response['redirectTo'], 2);
			return;
		}

		$email = Configure::read('Message.replyTo');
		$this->__setFlash("Não foi possível iniciar processo de pagamento. Entre em contato atráves do email {$email}", 'error');
		$this->redirect(array('action' => 'index'));
	}

	public function participant_pay($subscription_id) {

		if(isset($this->request->data['Subscription']['id'])) {
			$subscription_id = $this->request->data['Subscription']['id'];
		}

		$eventData = $this->Payment->Subscription->find('first', array('conditions' => array('Subscription.id' => $subscription_id)));

		$this->Payment->Subscription->id = $subscription_id;
		$payment = $this->Payment->Subscription->buildPaymentParams($eventData['Event'], $this->activeUser, $eventData['EventPrice']['id']);
		$name = substr($this->activeUser['name'] . ' ' . $this->activeUser['nickname'], 0, 50);

		$this->Checkout->setReference($payment['reference']);
		unset($payment['reference']);
		$this->Checkout->setItem($payment['item']);
		unset($payment['item']);
		$this->Checkout->setCustomer($this->activeUser['email'], $name);
		unset($payment['sender']);

		$this->Checkout->config($payment);
		$response = $this->Checkout->finalize(false);

		if(isset($response['checkout'])) {
			$msg = __("Iremos agora redirecionar você para o PagSeguro, onde será possível efetivar o pagamento.");
			$this->flash($msg, $response['redirectTo'], 2);
			return;
		}

		$email = Configure::read('Message.replyTo');
		$this->__setFlash("Não foi possível iniciar processo de pagamento. Entre em contato atráves do email {$email}", 'error');
		$this->redirect(array('controller' => 'subscriptions', 'action' => 'view', $this->Subscription->id));
	}

	public function participant_add($subscription_id = null)
	{
		if(isset($this->request->data['Subscription']['id'])) {
			$subscription_id = $this->request->data['Subscription']['id'];
		}

		$subscription = $this->Payment->Subscription->find('first', array('conditions' => array('Subscription.id' => $subscription_id)));

		if ($subscription_id == null) {
			$this->__setFlash('Inscrição Inválida', 'error');
			$this->redirect(array('action' => 'index'));
		}

		if($subscription['Subscription']['user_id'] != $this->activeUser['id']) {
			$this->__setFlash('Você não possui autorização para realizar esta ação!', 'error');
			$this->redirect(array('action' => 'index'));
		}

		if($subscription['Event']['free']) {
			$this->__setFlash('Este evento é gratuito!', 'success');
			$this->__goBack();
		}

		if(!empty($subscription['Payment']['id'])) {
			$this->__setFlash('Este pagamento já foi informado!');
			$this->__goBack();
		}

		if (!empty($this->request->data)) {
			$this->Payment->create();
			$this->request->data['Payment']['subscription_id'] = $subscription_id;

			if ($this->Payment->save($this->request->data)) {
				$this->__setFlash('Pagamento Informado!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('O pagamento não pôde ser registrado. Tente novamente.');
		}

		$this->set(compact('subscription'));
	}

	/**
     * URL de notificação para o PagSeguro.
     *
     * @return string
     */
    public function notification()
    {
        $this->layout = 'ajax';

        $notification = $this->Notifications->read($this->request->data);

        if($notification === false) {
            throw new MethodNotAllowedException(__('Ação não permitida'));
        }

        if($this->Payment->receive($notification)) {
            $this->set('status', 'success');
        }

        $this->set('status', 'error');
    }

    /**
     * URL de retorno do PagSeguro, após um pagamento.
     *
     * Redireciona o usuário para página de Welcome
     */
    public function returning()
    {
        if(!$this->request->is('get') && !isset($this->request->query['transaction'])) {
            throw new MethodNotAllowedException(__('Ação não permitida'));
        }

        $payment = $this->Consult->getTransactionInfo($this->request->query['transaction']);
        $situation = $this->Payment->receive($payment);

        if($situation) {
            $this->__setFlash('Você foi redirecionado com sucesso. Agora pode acompanhar sua inscrição pela sua área no sistema.', 'success');
        } else {
        	$this->__setFlash('Não foi possível recuperar as informações da transação. Por favor, entre em contato com a organização do evento.', 'alert');
        }

        $this->redirect('/');
    }

    /**
     * Faz uma consulta na API pelos pagamentos realizados
     * em uma transação específica,
     * Atualiza o pagamento especificado e redireciona o usuário
     * para sua view.
     *
     * @param string $transactionCode
     */
    public function consult($id = null)
    {
        $this->Payment->id = $id;
        if (!$this->Payment->exists()) {
            throw new NotFoundException('Pagamento não encontrado.');
        }

        $this->Payment->contain();
        $payment = $this->Payment->read('transaction_code', $id);

        $situation = $this->Consult->getTransactionInfo($payment['Payment']['transaction_code']);

        if(!isset($situation['errors'])) {
            $this->Payment->receive($situation);
        }

        $this->redirect(array('action'  => 'view', $id));
    }

    /**
     * Faz uma consulta na API pelos pagamentos realizados
     * entre duas datas e sincroniza as informações dos pagamentos
     * realizados com os do sistema.
     *
     */
    public function consultTransactions()
    {
        // Faz busca entre período
        if($this->request->is('post')) {

            if(!isset($this->request->data['Payment']['start']) || !isset($this->request->data['Payment']['end'])) {
                $this->__setFlash('Dados necessários não foram passados (start e end).', 'error');
                return;
            }

            try {
                $fdt1 = implode('-', array_reverse(explode('/', $this->request->data['Payment']['start'])));
                $fdt2 = implode('-', array_reverse(explode('/', $this->request->data['Payment']['end'])));

                $dt1 = new DateTime($fdt1);
                $dt2 = new DateTime($fdt2);

                $situations = $this->Consult->getTransactions($dt1, $dt2);

                while($situations['pages'] != $situations['current']) {
                    $others = $this->Consult->getTransactions($dt1, $dt2, $situations['current']++);
                    $situations['items'] = array_merge_recursive($situations['items'], $others['items']);
                }

                if($this->Payment->updateSituations('PagSeguro', $situations)) {
                    $this->__setFlash('Os pagamentos foram sincronizadas.', 'success');
                    $this->redirect(array('action' => 'index'));
                }

                $this->__setFlash('Não há nada para sincronizar no período fornecido.', 'success');

            } catch(Exception $e) {
                $this->__setFlash('Forneça duas datas válidas.', 'error');
            }
        }
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