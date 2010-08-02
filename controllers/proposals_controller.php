<?php
class ProposalsController extends AppController {

	public $name = 'Proposals';
	public $uses = array('Proposal');
  
	public $helpers = array('TinyMce.TinyMce');

	public function isAuthorized()
	{
		if($this->userLogged === TRUE && $this->params['prefix'] == User::get('type'))
		{
			return true;
		}

		return false;
	}
  
	/********
	 * Ações do usuário Palestrante
	 */
	function speaker_index()
	{
		$this->paginate['contain'] = array('User', 'Event');
		$proposals = $this->paginate('Proposal', array('user_id' => $this->activeUser['User']['id']));

		if(isset($proposals) && !empty($proposals))
		{
			$this->set('proposals', $proposals);
		}
	}

	function speaker_view($id = null)
	{
		if (!$id) 
		{
			$this->Session->setFlash(__('Proposta Inexistente', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		$proposal =  $this->Proposal->find('first',array(
			'conditions' => array(
				'Proposal.user_id' => $this->activeUser['User']['id'],
				'Proposal.id' => $id 
			),		
		));
		
		if(!empty($proposal))
		{
			$this->set('proposal',$proposal);
		}
		else
		{
			$this->redirect(array('action' => 'index'));
		}
		
	}

	function speaker_add()
	{
		if (!empty($this->data)) 
		{
			if (empty($this -> activeUser['User']['id']))
			{
				$this->Session->setFlash(__('Erro: o identificador do usuário não pôde ser encontrado. Por gentileza, notifique o administrador.', true));
				$this->redirect(array('action' => 'index'));
			}

			$this->data['Proposal']['user_id'] = $this -> activeUser['User']['id'];
			$this->Proposal->create();
      
			if ($this->Proposal->save($this->data))
			{
				$this->Session->setFlash(__('Proposta Salva!', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Proposta não pode ser submetida. Verifique os dados ou entre em contato com os organizadores do evento', true), 'default', array('class' => 'error'));
			}
		}
		$users = $this->Proposal->User->find('list');
 	 	$events = $this->Proposal->Event->find('list');
		$this->set(compact('users', 'events'));
		$this->setView();
	}

	function speaker_edit($id = null) 
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Proposta inválida', true), 'default', array('class' => 'attention'));
			$this->__goBack();
		}
		
		if (!empty($this->data))
		{
			$this->data['Proposal']['user_id'] = User::get('id');
			
			if ($this->Proposal->save($this->data))
			{
				$this->Session->setFlash(__('Alterações salvas', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('As alterações não puderam ser salva. Tente novamente, por favor.', true), 'default', array('class' => 'attention'));
			}
		}
		
		if (empty($this->data))
		{
			$this->data = $this->Proposal->read(null, $id);
		}
		
		$this->set(compact('users'));
    	$this -> setView($id);
	}

	public function speaker_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Proposta inválida', true), 'default', array('class' => 'attention'));
			$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Proposal->delete($id))
		{
			$this->Session->setFlash(__('Proposta removida', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Proposta não foi removida', true), 'default', array('class' => 'attention'));
		$this->redirect(array('action' => 'index'));
	}

	public function admin_index()
	{
		$this->Proposal->recursive = 0;
		
		if(isset($this->data))
		{
			$approved = $this->data['Proposal']['approved'];
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
			$this->Session->setFlash(__('Proposta inválida', true), 'default', array('class' => 'attention'));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->set('proposal', $this->Proposal->read(null, $id));
	}

	function admin_add()
	{
		if (!empty($this->data))
		{
			$this->Proposal->create();
			if ($this->Proposal->save($this->data))
			{
				$this->Session->setFlash(__('Proposta salva', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('A proposta não pode ser salva. Tente novamente, por favor.', true), 'default', array('class' => 'attention'));
			}
		}
		
		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));

		$this->setView();
	}

	function admin_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Proposta inválida', true), 'default', array('class' => 'attention'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data))
		{
			if ($this->Proposal->save($this->data))
			{
				$this->Session->setFlash(__('Alterações na proposta foram salva', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('As alterações não puderam ser salvas. Tente novamente, por favor.', true), 'default', array('class' => 'attention'));
			}
		}
		else
		{
			$this->data = $this->Proposal->read(null, $id);
		}
		
		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Proposta inválida', true), 'default', array('class' => 'attention'));
			$this->redirect(array('action'=>'index'));
		}
		
		if ($this->Proposal->delete($id))
		{
			$this->Session->setFlash(__('Proposta removida', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('A proposta não pode ser removida', true), 'default', array('class' => 'attention'));
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
				$msg = ($approve ? 'Aprovada' : 'Rejeitada');
				$this->Session->setFlash(__("Proposta $msg", true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'view', $id));
			}
			else
			{
				$this->Session->setFlash(__("Proposta não pode ser alterada ", true), 'default', array('class' => 'error'));
				$this->redirect(array('action'=>'index'));
			}
		}
		else
		{
			$this->Session->setFlash(__("Proposta não pode ser alterada ", true), 'default', array('class' => 'error'));
			$this->redirect(array('action'=>'index'));	
		}
	}
	
	function setView()
	{
		$events = $this->Proposal->Event->find('list', array('conditions' => array('Event.open_for_proposals' => 1)));
	    $this->set(compact('events'));
	
	  }
  
  
  function admin_rating($id = null)
  {
  	if(!empty($this->data))
  	{
  		$this->data['Proposal']['avaliator'] = $this->activeUser['User']['name'];
  		if($this->Proposal->save($this->data, false))
  		{
  			$this->Session->setFlash(__('Avaliação registrada',true), 'default', array('class' => 'success'));
  			$this->redirect('index');
  		}
  		else
  		{
  			$this->Session->setFlash(__('Avaliação não pode ser registrada',true), 'default', array('class' => 'error'));
			$this->redirect('index');
  		}
  	}
  	if(isset($id))
  		$this->set('id', $id);
  	else
  		$this->Session->setFlash(__('Avaliação registrada',true), 'default', array('class' => 'error'));
  		
  }
	
}
?>