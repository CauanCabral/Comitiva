<?php
class PaymentsController extends AppController {

	var $name = 'Payments';
	
	/*
	 * Ações para rota administrativa
	 */
	function admin_index() {
		$this->Payment->recursive = 0;
		$this->set('payments', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Pagamento inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('payment', $this->Payment->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Payment->create();
			if ($this->Payment->save($this->data)) {
				$this->Session->setFlash(__('Novo pagamento efetuado!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O pagamento não pôde ser salvo. Tente novamente.', true));
			}
		}
		$subscriptions = $this->Payment->Subscription->find('list');
		$this->set(compact('subscriptions'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Pagamento inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Payment->save($this->data)) {
				$this->Session->setFlash(__('Pagamento atualizado!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O pagamento não pôde ser atualizado. Tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Payment->read(null, $id);
		}
		$subscriptions = $this->Payment->Subscription->find('list');
		$this->set(compact('subscriptions'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Id de pagamento inválido', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Payment->del($id)) {
			$this->Session->setFlash(__('Pagamento apagado!', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Pagamento não foi apagado.', true));
		$this->redirect(array('action' => 'index'));
	}
	
	/*
	 * Ações para rota de participante
	 */
	function participant_index() {
		$this->Payment->recursive = 0;
		$this->set('payments', $this->paginate());
	}

	function participant_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Pagamento inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('payment', $this->Payment->read(null, $id));
	}

	function participant_add() {
		if (!empty($this->data)) {
			$this->Payment->create();
			if ($this->Payment->save($this->data)) {
				$this->Session->setFlash(__('Novo pagamento efetuado!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O pagamento não pôde ser salvo. Tente novamente.', true));
			}
		}
		$subscriptions = $this->Payment->Subscription->find('list');
		$this->set(compact('subscriptions'));
	}

	function participant_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Pagamento inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Payment->save($this->data)) {
				$this->Session->setFlash(__('Pagamento atualizado!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O pagamento não pôde ser atualizado. Tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Payment->read(null, $id);
		}
		$subscriptions = $this->Payment->Subscription->find('list');
		$this->set(compact('subscriptions'));
	}
}
?>