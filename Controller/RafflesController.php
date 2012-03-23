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
			$winner = $this->Raffle->random($this->request->data['reincident']);

			if($winner === 0)
			{
				$this->Session->setFlash(__('Não há usuários para sortear'));
			}	

			$this->set('winner', $winner);
		}
	}

	public function delete($id = null) 
	{
	}
}
