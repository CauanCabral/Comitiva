<?php
class UsersController extends AppController {

	var $name = 'Users';
	
	/*
	 * Ações para rota administrativa
	 */

	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Usuário Inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('Novo usuário salvo!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O usuário não pôde ser salvo. Tente novamente.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Usuario inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('Usuário atualizado!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O usuário não pôde ser atualizado. Tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Id de usuário inválido.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('Usuário apagado', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Usuário não foi apagado', true));
		$this->redirect(array('action' => 'index'));
	}
	
	/*
	 * Ações para rota de participante
	 */
	function participant_index() {
			$this->User->recursive = 0;
			$this->set('users', $this->paginate());
		}
	
	function participant_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Usuário inválido.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function participant_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('Novo usuário salvo!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Novo usuário não pôde ser salvo. Tente novamente.', true));
			}
		}
	}

	function participant_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Usuário inválido.', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('Usuario atualizado!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O usuário não pôde ser atualizado. Tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function participant_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Id de usuário inválido!', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('Usuário apagado!', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Usuário não foi apagado', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>