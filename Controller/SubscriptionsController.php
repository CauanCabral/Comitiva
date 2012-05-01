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
			$this->__setFlash('Inscrição inválida.');
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
				$this->__setFlash('Nova inscrição  salva com sucesso!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('A inscrição não pôde ser salva. Tente novamente.');
		}

		$users = $this->Subscription->User->getList();
		$events = $this->Subscription->Event->getList();
		$this->set(compact('users', 'events'));
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
				$this->__setFlash('A inscrição não pôde ser realizada. Verifique se o evento ainda está disponível.');
				$this->redirect(array('action' => 'index'));
			}

			// verifica se o evento é mesmo válido
			if($this->Subscription->Event->read(null, $event_id) === false || !$this->Subscription->Event->openToSubscription($event_id))
			{
				//caso não seja saí da inscrição
				$this->__setFlash('A inscrição não pôde ser realizada. O evento não existe ou as inscrições foram encerradas.', 'warning');
				$this->redirect(array('action' => 'index'));
			}

			$this->Subscription->create();

			$this->request->data['Subscription']['event_id'] = $event_id;
			$this->request->data['Subscription']['user_id'] = $this->activeUser['id'];

			if ($this->Subscription->save($this->request->data))
			{
				$this->__setFlash('Sua inscrição no evento foi efetuada!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('A inscrição não pôde ser realizada. Tente novamente.');
			$this->redirect(array('action' => 'index'));
		}

		if($event_id != null)
		{
			$subscription = $this->Subscription->find('first', array('recursive' => -1, 'conditions' => array('event_id' => $event_id, 'user_id' => $this->activeUser['id'])));

			if(!empty($subscription))
			{
				$this->__setFlash('Sua inscrição neste evento já foi efetuada!');
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
		// verifica se a inscrição está registrada para o usuário logado
		if(!empty($subscription))
		{
			// caso não esteja somente seta a mensagem de erro
			$this->__setFlash('Inscrição inválida.', 'error');
		}
		else if(!$subscription['Event']['free'])
		{
			$this->__setFlash('Não é possível cancelar a inscrição.', 'error');
		}
		// caso contrário tenta excluir a inscrição
		else if ($this->Subscription->delete($id))
		{
			// se for excluída, define mensagem de sucesso
			$this->__setFlash('Inscriçao removida!', 'success');
		}
		else
		{
			// caso contrário define mensagem de falha
			$this->__setFlash('Inscrição não foi removida', 'error');
		}

		$this->__goBack();
	}
}