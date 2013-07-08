<?php
App::uses('AppController', 'Controller');
/**
 * CertifiedModels Controller
 *
 * @property CertifiedModel $CertifiedModel
 */
class CertifiedModelsController extends AppController
{
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CertifiedModel->recursive = 0;
		$this->set('certifiedModels', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CertifiedModel->id = $id;
		if (!$this->CertifiedModel->exists()) {
			throw new NotFoundException(__('Invalid %s', __('certified model')));
		}
		$this->set('certifiedModel', $this->CertifiedModel->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CertifiedModel->create();
			if ($this->CertifiedModel->save($this->request->data)) {
				$this->Session->setFlash(
					__('O certificado foi salvo'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('O certificado não foi salvo. Por favor, tente novamente.'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CertifiedModel->id = $id;
		if (!$this->CertifiedModel->exists()) {
			throw new NotFoundException(__('Invalid %s', __('certified model')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CertifiedModel->save($this->request->data)) {
				$this->Session->setFlash(
					__('O certificado foi alterado'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('O certificado não foi alterado. Por favor, tente novamente.'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->CertifiedModel->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->CertifiedModel->id = $id;
		if (!$this->CertifiedModel->exists()) {
			throw new NotFoundException(__('Invalid %s', __('certified model')));
		}
		if ($this->CertifiedModel->delete()) {
			$this->Session->setFlash(
				__('O certificado foi excluído'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('O certificado não foi excluído'),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CertifiedModel->recursive = 0;
		$this->set('certifiedModels', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->CertifiedModel->id = $id;
		if (!$this->CertifiedModel->exists()) {
			throw new NotFoundException(__('Invalid %s', __('certified model')));
		}
		$this->set('certifiedModel', $this->CertifiedModel->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CertifiedModel->create();
			if ($this->CertifiedModel->save($this->request->data)) {
				$this->Session->setFlash(
					__('O certificado foi salvo'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('O certificado não foi salvo. Por favor, tente novamente.'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		}
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->CertifiedModel->id = $id;
		if (!$this->CertifiedModel->exists()) {
			throw new NotFoundException(__('Invalid %s', __('certified model')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CertifiedModel->save($this->request->data)) {
				$this->Session->setFlash(
					__('O certificado foi alterado', __('certified model')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('O certificado não foi alterado. Por favor, tente novamente.', __('certified model')),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->CertifiedModel->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->CertifiedModel->id = $id;
		if (!$this->CertifiedModel->exists()) {
			throw new NotFoundException(__('Invalid %s', __('certified model')));
		}
		if ($this->CertifiedModel->delete()) {
			$this->Session->setFlash(
				__('O certificado foi excluído', __('certified model')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('O certificado não foi excluído', __('certified model')),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
