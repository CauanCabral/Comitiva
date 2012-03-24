<?php
App::uses('AppController', 'Controller');
/**
 * Awards Controller
 *
 * @property Award $Award
 */
class AwardsController extends AppController {

/**
 *  Layout
 *
 * @var string
 */
	public $layout = 'default';

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Session');
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() 
	{
		$this->Award->recursive = 0;
		$this->set('awards', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null)
	{
		$this->Award->id = $id;
		if (!$this->Award->exists())
		{
			throw new NotFoundException(__('Sorteio não encontrado'));
		}
		$this->set('award', $this->Award->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add()
	{
		if ($this->request->is('post'))
		{
			$this->Award->create();
			if ($this->Award->save($this->request->data))
			{
				$this->Session->setFlash(
					__('Sorteio criado!'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} 
			else
			{
				$this->Session->setFlash(
					__('Não foi possível criar o sorteio. Tente novamente'),
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
	public function admin_edit($id = null)
	{
		$this->Award->id = $id;
		if (!$this->Award->exists())
		{
			throw new NotFoundException(__('Sorteio não encontrado'));
		}

		if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->Award->save($this->request->data))
			{
				$this->Session->setFlash(
					__('Sorteio atualizado!'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} 
			else
			{
				$this->Session->setFlash(
					__('Não foi possível atualizar o sorteio. Tente novamente'),
					'alert',
					array(
						'plugin' => 'TwitterBootstrap',
						'class' => 'alert-error'
					)
				);
			}
		} 
		else
		{
			$this->request->data = $this->Award->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null)
	{
		if (!$this->request->is('post'))
		{
			throw new MethodNotAllowedException();
		}
		
		$this->Award->id = $id;
		
		if (!$this->Award->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('award')));
		}
		
		if ($this->Award->delete()) 
		{
			$this->Session->setFlash(
				__('Sorteio excluído!'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('Não foi possível excluir o sorteio. Tente novamente'),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}
}
