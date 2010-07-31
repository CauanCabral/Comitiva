<?php
class ProposalsController extends AppController {

	public $name = 'Proposals';
  public $uses = array('Proposal');
  
  public function isAuthorized()
	{
		if($this->userLogged === TRUE && $this->params['prefix'] == User::get('type'))
		{
			return true;
		}

		return false;
	}
  
	function index() {
    $this->paginate['contain'] = array('User', 'Event');
		$this->set('proposals', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid proposal', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('proposal', $this->Proposal->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
      if (empty($this -> activeUser['User']['id'])) {
        $this->Session->setFlash(__('Erro: o identificador do usuário não pôde ser encontrado. Por gentileza, notifique o administrado.', true));
				$this->redirect(array('action' => 'index'));
      }

      $this -> data['Proposal']['user_id'] = $this -> activeUser['User']['id'];
			$this->Proposal->create();
      
			if ($this->Proposal->save($this->data)) {
				$this->Session->setFlash(__('The proposal has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The proposal could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Proposal->User->find('list');
    $events = $this->Proposal->Event->find('list');
		$this->set(compact('users', 'events'));

    $this -> setView();
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid proposal', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Proposal->save($this->data)) {
				$this->Session->setFlash(__('The proposal has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The proposal could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Proposal->read(null, $id);
		}
		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));

    $this -> setView($id);
    $this -> render('add');
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for proposal', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Proposal->delete($id)) {
			$this->Session->setFlash(__('Proposal deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Proposal was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function admin_index() {
		$this->Proposal->recursive = 0;
		$this->set('proposals', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid proposal', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('proposal', $this->Proposal->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Proposal->create();
			if ($this->Proposal->save($this->data)) {
				$this->Session->setFlash(__('The proposal has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The proposal could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));

    $this -> setView($id);
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid proposal', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Proposal->save($this->data)) {
				$this->Session->setFlash(__('The proposal has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The proposal could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Proposal->read(null, $id);
		}
		$users = $this->Proposal->User->find('list');
		$this->set(compact('users'));

    $this -> setView($id);
    $this -> render('add');
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for proposal', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Proposal->delete($id)) {
			$this->Session->setFlash(__('Proposal deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Proposal was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

  function setView() {
    $events = $this->Proposal->Event->find('list', array('conditions' => array('Event.open_for_proposals' => 1)));

    $this->set(compact('events'));

  }
}
?>