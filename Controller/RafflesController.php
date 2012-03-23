<?php
App::uses('AppController', 'Controller');
/**
 * Raffles Controller
 *
 * @property Raffle $Raffle
 */
class RafflesController extends AppController
{
	public function admin_index()
	{
		pr($this->Raffle->random());
		$this->Raffle->recursive = 0;
		$this->set('raffles', $this->paginate());
	}

	public function admin_view($id = null)
	{
		$this->Raffle->id = $id;

		if (!$this->Raffle->exists()) {
			throw new NotFoundException(__('Sorteio não existe'));
		}

		$this->set('raffle', $this->Raffle->read(null, $id));
	}

	public function admin_new() 
	{
		if ($this->request->is('post')) 
		{
			$this->Raffle->create();
			if ($this->Raffle->save($this->request->data)) 
			{
				$this->Session->setFlash(__(''));
				$this->redirect(array('action' => 'index'));
			} 
			else
			{
				$this->Session->setFlash(__('Problema na realização do sorteio'));
			}
		}
	}

	public function delete($id = null) 
	{
	}
}
