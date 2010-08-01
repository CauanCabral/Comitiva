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

	/**
	 * 
	 * 
	 */
	public function participant_index() 
	{
		$this->paginate = array(
			'conditions' => array(
				'Proposal.user_id' => User::get('id')
			)
		);
	}

	/**
	 * 
	 * 
	 * @param int $id
	 */
	public function participant_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Proposta inválida', true), 'default', array('class' => 'attention'));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->set('proposal', $this->Proposal->find(
			'first',
			array(
				'conditions' => array(
					'Proposal.id' => $id,
					'Proposal.user_id' => User::get('id')
					)
				)
			)
		);
	}

	/**
	 * 
	 * 
	 */
	public function participant_add()
	{
		if (!empty($this->data))
		{
			$this->data['Proposal']['user_id'] = User::get('id');

			if ($this->Proposal->save($this->data))
			{
				$this->Session->setFlash(__('Proposta enviada', true), 'default', array('class' => 'success'));
				$this->__goBack();
			}
			else
			{
				$this->Session->setFlash(__('Sua proposta não pode ser enviada. Tente novamente, por favor.', true), 'default', array('class' => 'attention'));
			}
		}
		
		$events = $this->Proposal->Event->find('list');
		$this->set(compact('users', 'events'));

		$this->setView();
	}

	/**
	 * 
	 * 
	 * @param int $id
	 */
	public function participant_edit($id = null)
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

		$this->setView();
		$this->render('participant_add');
	}

	public function participant_delete($id = null)
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
		
		if (empty($this->data))
		{
			$this->data = $this->Proposal->read(null, $id);
		}
		
		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));

		$this->setView();
		$this->render('add');
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

	function setView()
	{
		$events = $this->Proposal->Event->find('list', array('conditions' => array('Event.open_for_proposals' => 1)));

		$this->set(compact('events'));

	}
}
?>