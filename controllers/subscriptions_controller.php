<?php
class SubscriptionsController extends AppController {

	var $name = 'Subscriptions';
	
	/*
	 * Ações para rota administrativa
	 */
	function admin_index() {
		$this->Subscription->recursive = 0;
		$this->set('subscriptions', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Inscrição inválida.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('subscription', $this->Subscription->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Subscription->create();
			if ($this->Subscription->save($this->data)) {
				$this->Session->setFlash(__('Nova inscrição  salva com sucesso!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('A inscrição não pôde ser salva. Tente novamente.', true));
			}
		}
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Inscrição inválida', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Subscription->save($this->data)) {
				$this->Session->setFlash(__('Inscrição atualizada com sucesso!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('A inscrição não pôde ser salva. Tente novamente.', true));
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
			$this->Session->setFlash(__('Id de inscrição inválido!', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Subscription->del($id)) {
			$this->Session->setFlash(__('Inscrição apagada!', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Inscrição não foi apagada', true));
		$this->redirect(array('action' => 'index'));
	}
	
	/*
	 * Ações para rota de participantes
	 */
	function participant_index() {
		$this->Subscription->recursive = 0;
		//$this->set('subscriptions', $this->paginate());
	}

	function participant_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Inscrição inválida', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('subscription', $this->Subscription->read(null, $id));
	}

	function participant_add() {
		if (!empty($this->data)) {
			$this->Subscription->create();
			if ($this->Subscription->save($this->data)) {
				$this->Session->setFlash(__('Nova inscrição salva!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('A inscrição não pôde ser salva. Tente novamente.', true));
			}
		}
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	function participant_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Inscrição inválida', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Subscription->save($this->data)) {
				$this->Session->setFlash(__('Inscrição Salva!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('A inscrição não pôde ser salva. Tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Subscription->read(null, $id);
		}
		$users = $this->Subscription->User->find('list');
		$events = $this->Subscription->Event->find('list');
		$this->set(compact('users', 'events'));
	}

	function participant_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Id de inscrição inválido!', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Subscription->del($id)) {
			$this->Session->setFlash(__('Inscriçao apagada!', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Inscrição não foi apagada', true));
		$this->redirect(array('action' => 'index'));
	}
	
}
?>