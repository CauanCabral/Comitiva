<?php
class ProposalsController extends AppController {

	public $name = 'Proposals';
	public $uses = array('Proposal');
  	public $components = array('Mailer.Mailer');
	public $helpers = array('TinyMce.TinyMce', 'Locale.Locale');
  
	/********
	 * Ações do usuário Palestrante
	 */
	function participant_index()
	{
		$this->paginate['contain'] = array('User', 'Event');
		$proposals = $this->paginate('Proposal', array('user_id' => User::get('id')));

		if(isset($proposals) && !empty($proposals))
		{
			$this->set('proposals', $proposals);
		}
	}

	function participant_view($id = null)
	{
		if (!$id) 
		{
			$this->Session->setFlash(__('Proposta Inexistente'), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		$proposal =  $this->Proposal->find('first',array(
			'conditions' => array(
				'Proposal.user_id' => User::get('id'),
				'Proposal.id' => $id 
			),		
		));
		
		if(!empty($proposal))
		{
			$this->set('proposal',$proposal);
		}
		else
		{
			$this->Session->setFlash(__('Proposta Inválida'), 'default', array('class' => 'error'));
			$this->__goBack();
		}
	}

	function participant_add($event_id = null)
	{
		if (!empty($this->request->data)) 
		{
			if (empty($this->activeUser['User']['id']))
			{
				$this->Session->setFlash(__('Erro: o identificador do usuário não pôde ser encontrado. Por gentileza, notifique o administrador.'));
				$this->redirect(array('action' => 'index'));
			}

			$this->request->data['Proposal']['user_id'] = User::get('id');
			
			if ($this->Proposal->save($this->request->data))
			{
				$this->Session->setFlash(__('Proposta Submetida!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Proposta não pode ser submetida. Verifique os dados ou entre em contato com os organizadores do evento'), 'default', array('class' => 'attention'));
			}
		}
		
		$users = $this->Proposal->User->find('list');
 	 	$events = $this->Proposal->Event->find('list', array('conditions' => array('Event.open_for_proposals' => 1)));

 	 	if(isset($event_id) && !array_key_exists($event_id, $events))
 	 	{
 	 		$this->Session->setFlash(__('O evento selecionado não está aberto a propostas. Selecione outro evento'), 'default', array("class" => 'attention'));
 	 		$event_id = 0; 
 	 	}
 	 	
 	 	$event_id = (isset($event_id) ? $event_id : 0);
		$this->set(compact('users', 'events', 'event_id'));
	}

	function participant_edit($id = null) 
	{
		if (!$id && empty($this->request->data))
		{
			$this->Session->setFlash(__('Proposta inválida'), 'default', array('class' => 'attention'));
			$this->__goBack();
		}
		
		if (!empty($this->request->data))
		{
			$this->request->data['Proposal']['user_id'] = User::get('id');
			
			if ($this->Proposal->save($this->request->data))
			{
				$this->Session->setFlash(__('Alterações salvas'), 'default', array('class' => 'success'));
				$this->__goBack();
			}
			else
			{
				$this->Session->setFlash(__('As alterações não puderam ser salva. Tente novamente, por favor.'), 'default', array('class' => 'attention'));
			}
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
			$this->Session->setFlash(__('Proposta inválida'), 'default', array('class' => 'attention'));
			$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Proposal->delete($id))
		{
			$this->Session->setFlash(__('Proposta removida'), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Proposta não foi removida'), 'default', array('class' => 'attention'));
		$this->redirect(array('action' => 'index'));
	}

	public function admin_index()
	{
		$this->Proposal->recursive = 0;
		
		if(isset($this->request->data))
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
			$this->Session->setFlash(__('Proposta inválida'), 'default', array('class' => 'attention'));
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
				$this->Session->setFlash(__('Proposta salva'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('A proposta não pode ser salva. Tente novamente, por favor.'), 'default', array('class' => 'attention'));
			}
		}
		
		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));

		$this->setView();
	}

	function admin_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->Session->setFlash(__('Proposta inválida'), 'default', array('class' => 'attention'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data))
		{
			if ($this->Proposal->save($this->request->data))
			{
				$this->Session->setFlash(__('Alterações na proposta foram salva'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('As alterações não puderam ser salvas. Tente novamente, por favor.'), 'default', array('class' => 'attention'));
			}
		}
		else
		{
			$this->request->data = $this->Proposal->read(null, $id);
		}
		
		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));
		
		$this->setView();
	}

	function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Proposta inválida'), 'default', array('class' => 'attention'));
			$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Proposal->delete($id))
		{
			$this->Session->setFlash(__('Proposta removida'), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('A proposta não pode ser removida'), 'default', array('class' => 'attention'));
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
						$this->Session->setFlash(__('Não foi possível atualizar o grupo do usuário.'), 'default', array('class' => 'attention'));
					}
				}
				
				$appr = ($approve ? 'Aprovada' : 'Rejeitada');
				
				$greetings =  ($approve ? 'Parabéns, ': 'Olá, ');
				
				if($approve)
				{
					$message = '<p>Sua proposta de apresentação no evento '.$proposal['Event']['title'] . ' foi aprovada pela comissão organizadora do evento. Entre em contato com a comissão organizadora o mais rápido para acertar os detalhes.<br/><br/>';
				}
				else
				{
					$message = '<p>Sua proposta de apresentação no evento '.$proposal['Event']['title'] . '  não foi aprovada. Agradecemos profundamente o seu interesse e esperamos sua proposta em eventos futuros. Caso haja alguma dúvida entre em contato com a equipe organizadora.<br/><br/>';
				}
				
				$sign = '<p> Atenciosamente </p><p> Equipe Organizadora</p>';
				
				$this->Session->setFlash(__("Proposta $appr"), 'default', array('class' => 'success'));
			
  				$msg = array(
	  				'to' =>  $proposal['User']['email'],
	  				'from' => 'admin@comitiva.com.br',
	  				'subject' => '[Comitiva] Sua proposta foi aprovada' ,
	  				'body' => 
  						$greetings . $proposal['User']['name'] . '<br/><br/>' .  
  						$message . '<br/><br/>'.
  						$sign
  				);
  			
				if(!$this->Mailer->sendMessage($msg))
					$this->Session->setFlash(__('Não foi possivel enviar e-mail. Verifique as configurações do servidor'), 'default', array('class' => 'attention'));
				else 
					$this->Session->setFlash(__('Um e-mail foi enviado para o proponente'), 'default', array('class' => 'success'));
  				
				$this->redirect(array('action'=>'view', $id));
			}
			else
			{
				$this->Session->setFlash(__("Proposta não pode ser alterada "), 'default', array('class' => 'error'));
				$this->redirect(array('action'=>'index'));
			}
		}
		else
		{
			$this->Session->setFlash(__("Proposta não pode ser alterada "), 'default', array('class' => 'error'));
			$this->redirect(array('action'=>'index'));	
		}
	}
	
	function admin_rating($id = null)
	{
		if(!empty($this->request->data))
		{
			$proposal = $this->Proposal->read(null,$this->request->data['Proposal']['id']);
  		
			$this->request->data['Proposal']['avaliator'] = $this->activeUser['User']['name'];
  		
			if($this->Proposal->save($this->request->data, false))
			{
				$this->Session->setFlash(__('Avaliação registrada. A proposta ainda aguarda aprovação.'), 'default', array('class' => 'success'));
				
				$this->redirect('index');
			}
			else
			{
				$this->Session->setFlash(__('Avaliação não pode ser registrada'), 'default', array('class' => 'error'));
				$this->redirect('index');
			}
		}
		
		if(isset($id))
			$this->set('id', $id);
		else
			$this->Session->setFlash(__('Proposta invalida'), 'default', array('class' => 'attention'));
	}
	
	function setView()
	{
		$events = $this->Proposal->Event->find('list', array('conditions' => array('Event.open_for_proposals' => 1)));
		$this->set(compact('events'));
	}
}
?>