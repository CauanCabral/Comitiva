<?php
App::uses('Sanitize', 'Utility');
App::uses('Checkout', 'PagSeguro/Controller/Component');

class SubscriptionsController extends AppController
{
	public $name = 'Subscriptions';

	public $helpers = array(
		'Csv',
		'Locale.Locale'
	);

	public $components = array(
		'PagSeguro.Checkout',
		'Search.Prg'
	);

	public $presetVars = array(
		array('field' => 'query', 'type' => 'value')
	);

	/*
	 * Ações para rota administrativa
	 */
	public function admin_index($event_id = null)
	{
		$this->Subscription->recursive = 0;

		$this->Prg->commonProcess();
		$this->paginate['conditions'] = $this->Subscription->parseCriteria($this->passedArgs);

		if(is_numeric($event_id))
		{
			$this->paginate['conditions'] = array('Subscription.event_id' => $event_id);
		}

		$this->set(compact('event_id'));
		$this->set('subscriptions', $this->paginate());
	}

	public function admin_view($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Inscrição inválida.');
			$this->__goBack();
		}

		$this->set('subscription', $this->Subscription->read(null, $id));
	}

	public function admin_add($event_id = null)
	{
		if (!empty($this->request->data))
		{
			$this->Subscription->create();

			if ($this->Subscription->save($this->request->data))
			{
				$this->__setFlash('Nova inscrição  salva com sucesso!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('A inscrição não pôde ser salva. Tente novamente.');
		}

		if($event_id)
		{
			$this->request->data['Subscription']['event_id'] = $event_id;
		}

		$events = $this->Subscription->Event->getOpenToSubscriptionList();
		$this->set(compact('events'));
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->__setFlash('Inscrição inválida', 'error');
			$this->__goBack();
		}

		if (!empty($this->request->data))
		{
			if ($this->Subscription->save($this->request->data))
			{
				$this->__setFlash('Inscrição atualizada com sucesso!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->Session->setFlash('A inscrição não pôde ser salva. Tente novamente.');
		}

		if (empty($this->request->data))
		{
			$this->Subscription->contain(array('Event', 'User'));
			$this->request->data = $this->Subscription->find('first', array('conditions' => array('Subscription.id' => $id)));
			$this->request->data['Subscription']['user_name'] = $this->request->data['User']['fullName'];
		}

		$events = $this->Subscription->Event->getOpenToSubscriptionList();
		$this->set(compact('events'));
	}

	public function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Inscrição inválido!', 'error');
		}
		else if ($this->Subscription->delete($id))
		{
			$this->__setFlash('Inscrição removida!', 'success');
		}
		else
		{
			$this->__setFlash('Inscrição não foi removida');
		}

		$this->__goBack();
	}

	public function admin_checkin($id = null)
	{
		if(!$id)
		{
			$this->__setFlash('Inscrição inválido!', 'error');
			$this->__goBack();
		}

		$subscription = $this->Subscription->read(null, $id);

		if(!$subscription)
		{
			$this->__setFlash('Inscrição inválido!', 'error');
			$this->__goBack();
		}

		$this->Subscription->create($subscription);

		if($this->Subscription->saveField('checked', true))
		{
			$this->__setFlash('Check-in realizado com sucesso!', 'success');
		}
		else
		{
			$this->__setFlash('Falha no check-in.');
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
			$this->__setFlash('Inscrição inválida', 'error');
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
				$this->__setFlash('A inscrição não pôde ser realizada. Verifique se o evento ainda está disponível.', 'alert');
				$this->redirect(array('action' => 'index'));
			}

			// verifica se o evento é mesmo válido
			if(($eventData = $this->Subscription->Event->read(null, $event_id)) === false || !$this->Subscription->Event->openToSubscription($event_id))
			{
				$this->__setFlash('A inscrição não pôde ser realizada. O evento não existe ou as inscrições foram encerradas.', 'alert');
				$this->redirect(array('action' => 'index'));
			}

			$this->Subscription->create();

			$this->request->data['Subscription']['event_id'] = $event_id;
			$this->request->data['Subscription']['user_id'] = $this->activeUser['id'];

			if (!$this->Subscription->save($this->request->data)) {
				$this->__setFlash('A inscrição não pôde ser realizada. Tente novamente.', 'alert');
				$this->redirect(array('action' => 'index'));
			}

			if($eventData['Event']['free']) {
				$this->__setFlash(__("Sua inscrição no evento foi efetuada com sucesso!"), 'success');
				$this->redirect(array('action' => 'index'));
			} else {

				$payment = $this->Subscription->buildPaymentParams($eventData['Event'], $this->activeUser, $this->request->data['Subscription']['event_price_id']);
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
				$this->redirect(array('controller' => 'subscriptions', 'action' => 'view', $this->Subscription->id));
			}
		}

		if($event_id != null)
		{
			$subscription = $this->Subscription->find('first', array('recursive' => -1, 'conditions' => array('event_id' => $event_id, 'user_id' => $this->activeUser['id'])));

			if(!empty($subscription))
			{
				$this->__setFlash('Sua inscrição neste evento já foi efetuada!', 'error');
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
			$this->__setFlash('Inscrição inválida!', 'error');
			$this->__goBack();
		}

		$subscription = $this->Subscription->find('first', array('recursive' => -1, 'conditions' => array('event_id' => $id, 'user_id' => $this->activeUser['id'])));
		if(!empty($subscription))
		{
			$this->__setFlash('Inscrição inválida.', 'error');
		}
		else if(!$subscription['Event']['free'])
		{
			$this->__setFlash('Não é possível cancelar a inscrição.', 'error');
		}
		else if ($this->Subscription->delete($id))
		{
			$this->__setFlash('Inscriçao removida!', 'success');
		}
		else
		{
			$this->__setFlash('Inscrição não foi removida', 'error');
		}

		$this->__goBack();
	}

	/**
	 * Método que retorna em JSON uma lista de usuários que ainda
	 * não estão inscritos no evento passado.
	 *
	 * @param int $event_id
	 * @return void
	 */
	public function admin_ajaxGetNonParticipants($event_id)
	{
		$this->viewClass = 'Json';
		$this->view = null;

		if(!$this->Subscription->Event->exists($event_id))
			throw new NotFoundException("Evento não encontrado.");

		$this->Subscription->contain();
		$subscriptions = $this->Subscription->find('all', array('conditions' => array('event_id' => $event_id), 'fields' => array('user_id')));
		$ids = array();

		foreach($subscriptions as $subscription)
		{
			$ids[] = $subscription['Subscription']['user_id'];
		}

		$q = '%';
		if(isset($this->request->query['term']))
		{
			$q .= $this->request->query['term'] . '%';
		}

		$data = $this->Subscription->User->find('list', array(
			'conditions' => array(
				'User.id NOT' => $ids,
				'User.fullName LIKE' => $q
			),
			'fields' => array('User.id', 'User.fullName'),
			'contain' => array())
		);

		$output = array();
		foreach($data as $userId => $userName)
		{
			$output[] = array('id' => $userId, 'label' => $userName);
		}

		$this->set(compact('output'));
		$this->set('_serialize', 'output');
	}
}