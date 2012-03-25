<?php
App::uses('AppController', 'Controller');
/**
 * Awards Controller
 *
 * @property Award $Award
 */
class AwardsController extends AppController {

	public $helpers = array('TinyMCE.TinyMCE');

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

		$this->set('award', $this->Award->find('first', array(
			'conditions' => array('Award.id' => $id),
			'contain' => array('Raffle.User', 'Event')
		)));
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
			$groups = json_encode($this->request->data['Award']['groups']);
			$this->request->data['Award']['groups'] = $groups;

			$this->Award->create();
			if ($this->Award->save($this->request->data))
			{
				$this->__setFlash('Sorteio criado!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('Não foi possível criar o sorteio. Tente novamente', 'alert-error');
		}

		$events = $this->Award->Event->find('list');
		$this->set('events', $events);
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
			$groups = json_encode($this->request->data['Award']['groups']);
			$this->request->data['Award']['groups'] = $groups;
			
			if ($this->Award->save($this->request->data))
			{
				$this->__setFlash('Sorteio atualizado!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('Não foi possível atualizar o sorteio. Tente novamente', 'error');
		}
		else
		{
			$this->request->data = $this->Award->find('first',array(
				'conditions' => array('Award.id' => $id),
			));

			$events = $this->Award->Event->find('list');
			$this->set('events', $events);
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
		$this->Award->id = $id;

		if (!$this->Award->exists())
		{
			throw new NotFoundException(__('Invalid %s', __('award')));
		}

		if ($this->Award->delete())
		{
			$this->__setFlash('Sorteio excluído!', 'success');
			$this->redirect(array('action' => 'index'));
		}

		$this->__setFlash('Não foi possível excluir o sorteio. Tente novamente', 'error');
		$this->redirect(array('action' => 'index'));
	}
}