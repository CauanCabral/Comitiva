<?php
class SubscriptionsController extends AppController {

	var $name = 'Subscriptions';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Subscription->recursive = 0;
		//$this->set('subscriptions', $this->paginate());
	}

	/*function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Subscription', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('subscription', $this->Subscription->read(null, $id));
	}*/

	function add() {
		if (!empty($this->data)) {
			$this->Subscription->create();
			if ($this->Subscription->save($this->data)) {
				$this->Session->setFlash(__('The Subscription has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Subscription could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	/*function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Subscription', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Subscription->save($this->data)) {
				$this->Session->setFlash(__('The Subscription has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Subscription could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Subscription->read(null, $id);
		}
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}*/

	/*function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Subscription', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Subscription->del($id)) {
			$this->Session->setFlash(__('Subscription deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Subscription was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}*/
	
	function admin_index() {
		$this->Subscription->recursive = 0;
		$this->set('subscriptions', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Subscription', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('subscription', $this->Subscription->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Subscription->create();
			if ($this->Subscription->save($this->data)) {
				$this->Session->setFlash(__('The Subscription has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Subscription could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Subscription', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Subscription->save($this->data)) {
				$this->Session->setFlash(__('The Subscription has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Subscription could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Subscription->read(null, $id);
		}
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Subscription', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Subscription->del($id)) {
			$this->Session->setFlash(__('Subscription deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Subscription was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>