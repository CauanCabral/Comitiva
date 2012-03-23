<?php
class ProposalsController extends AppController {
	public $name = 'Proposals';
	public $helpers = array(
		'TinyMCE.TinyMCE',
		'Locale.Locale'
	);

	/********
	 * Ações do usuário Palestrante
	 */
	public function participant_index()
	{
		$this->paginate['contain'] = array('User', 'Event');
		$proposals = $this->paginate('Proposal', array('user_id' => $this->activeUser['id']));

		if(isset($proposals) && !empty($proposals))
		{
			$this->set('proposals', $proposals);
		}
	}

	public function participant_view($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Proposta Inexistente', 'error');
			$this->redirect(array('action' => 'index'));
		}

		$proposal =  $this->Proposal->find('first',array(
			'conditions' => array(
				'Proposal.user_id' => $this->activeUser['id'],
				'Proposal.id' => $id
			),
		));

		if(!empty($proposal))
		{
			$this->set('proposal', $proposal);
		}
		else
		{
			$this->__setFlash('Proposta Inválida', 'error');
			$this->__goBack();
		}
	}

	public function participant_add($event_id = null)
	{
		if (!empty($this->request->data))
		{
			if (empty($this->activeUser['id']))
			{
				$this->__setFlash('Erro: o identificador do usuário não pôde ser encontrado. Por gentileza, notifique o administrador.', 'error');
				$this->redirect(array('action' => 'index'));
			}

			$this->request->data['Proposal']['user_id'] = $this->activeUser['id'];

			if ($this->Proposal->save($this->request->data))
			{
				$this->__setFlash('Proposta Submetida!', 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->__setFlash('Proposta não pode ser submetida. Verifique os dados ou entre em contato com os organizadores do evento', 'attention');
			}
		}

		$users = $this->Proposal->User->find('list');
 	 	$events = $this->Proposal->Event->find('list', array('conditions' => array('Event.open_for_proposals' => true)));

 	 	if(isset($event_id) && !array_key_exists($event_id, $events))
 	 	{
 	 		$this->__setFlash('O evento selecionado não está aberto a propostas. Selecione outro evento', 'attention');
 	 		$event_id = 0;
 	 	}

 	 	$event_id = (isset($event_id) ? $event_id : 0);
		$this->set(compact('users', 'events', 'event_id'));
	}

	public function participant_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->__setFlash('Proposta inválida', 'attention');
			$this->__goBack();
		}

		if (!empty($this->request->data))
		{
			$this->request->data['Proposal']['user_id'] = $this->activeUser['id'];

			if ($this->Proposal->save($this->request->data))
			{
				$this->__setFlash('Alterações salvas', 'success');
				$this->__goBack();
			}

			$this->__setFlash('As alterações não puderam ser salva. Tente novamente, por favor.', 'attention');
		}

		if (empty($this->request->data))
		{
			$this->request->data = $this->Proposal->read(null, $id);
		}

		$this->set(compact('users'));
    	$this->setView($id);
	}

	public function participant_delete($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Proposta inválida', 'attention');
			$this->redirect(array('action'=>'index'));
		}

		if ($this->Proposal->delete($id))
		{
			$this->__setFlash('Proposta removida', 'success');
			$this->redirect(array('action'=>'index'));
		}

		$this->__setFlash('Proposta não foi removida', 'attention');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_index()
	{
		$this->Proposal->recursive = 0;

		if(!empty($this->request->data))
		{
			$approved = $this->request->data['Proposal']['approved'];
		}

		if(isset($approved))
			$this->set('proposals', $this->paginate(array('approved' => $approved)));
		else
			$this->set('proposals', $this->paginate());
	}

	public function admin_view($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Proposta inválida', 'attention');
			$this->redirect(array('action' => 'index'));
		}

		$this->set('proposal', $this->Proposal->read(null, $id));
	}

	function admin_add()
	{
		if (!empty($this->request->data))
		{
			$this->Proposal->create();
			if ($this->Proposal->save($this->request->data))
			{
				$this->__setFlash('Proposta salva', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('A proposta não pode ser salva. Tente novamente, por favor.', 'attention');
		}

		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));

		$this->setView();
	}

	function admin_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->__setFlash('Proposta inválida', 'attention');
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->request->data))
		{
			if ($this->Proposal->save($this->request->data))
			{
				$this->__setFlash('Alterações na proposta foram salva', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('As alterações não puderam ser salvas. Tente novamente, por favor.', 'attention');
			return;
		}

		$this->request->data = $this->Proposal->read(null, $id);

		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));

		$this->setView();
	}

	function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Proposta inválida', 'attention');
			$this->redirect(array('action'=>'index'));
		}

		if ($this->Proposal->delete($id))
		{
			$this->__setFlash('Proposta removida', 'success');
			$this->redirect(array('action'=>'index'));
		}

		$this->__setFlash('A proposta não pode ser removida', 'attention');
		$this->redirect(array('action' => 'index'));
	}

	function admin_approve($id = null, $approve = true)
	{
		if(isset($id) && isset($approve))
		{
			$data['Proposal']['id'] = $id;
			$data['Proposal']['approved'] = $approve;

			if($this->Proposal->save($data, false))
			{
				$proposal = $this->Proposal->find('first', array(
					'conditions' => array('Proposal.id' => $id),
					'contain' => array('User', 'Event')
				));

				$groups = json_decode($proposal['User']['groups'], true);

				// se o usuário ainda não pertencer ao grupo de palestrantes, faz a alteração
				if(!$this->__checkGroup('speaker', $groups))
				{
					$groups[] = 'speaker';

					$user['User']['id'] = $proposal['User']['id'];
					$user['User']['groups'] = json_encode($groups);

					if(!$this->Proposal->User->save($user))
					{
						$this->__setFlash('Não foi possível atualizar o grupo do usuário.', 'attention');
					}
				}

				$appr = ($approve ? __('aprovada') : __('rejeitada'));

				$this->__setFlash("Proposta {$appr}", 'success');

  				$email = new CakeEmail();

				/* Setup parameters of EmailComponent */
				$email->to($proposal['User']['email'])
						->subject('[' . Configure::read('Comitiva.name') . ' - Inscrições] Sua proposta foi ' . $appr)
						->replyTo(Configure::read('Message.replyTo'))
						->from(Configure::read('Message.from'))
						->template('proposal_feedback')
						->emailFormat('html');

				if($email->send())
				{
					$this->__setFlash('Um e-mail foi enviado para o proponente', 'sucess');
					return;
				}

				$this->__setFlash('Não foi possivel enviar e-mail. Verifique as configurações do servidor', 'attention');
				$this->redirect(array('action'=>'view', $id));
			}
		}

		$this->__setFlash('Proposta não pode ser alterada', 'error');
		$this->redirect(array('action'=>'index'));
	}

	function admin_rating($id = null)
	{
		if(!empty($this->request->data))
		{
			$proposal = $this->Proposal->read(null,$this->request->data['Proposal']['id']);

			$this->request->data['Proposal']['avaliator'] = $this->activeUser['name'];

			if($this->Proposal->save($this->request->data))
			{
				$this->__setFlash('Avaliação registrada. A proposta ainda aguarda aprovação.', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('Avaliação não pode ser registrada', 'error');
			$this->redirect(array('action' => 'index'));
		}

		if(!empty($id))
			$this->set('id', $id);
		else
			$this->__setFlash('Proposta invalida', 'attention');
	}

	protected function setView()
	{
		$events = $this->Proposal->Event->find('list', array('conditions' => array('Event.open_for_proposals' => true)));
		$this->set(compact('events'));
	}
}