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
			$raffle['award_id'] = $this->request->data['Raffle']['award_id'];
			$raffle['user_id'] = $this->request->data['Raffle']['user_id'];

			$this->Raffle->create();
			if($this->Raffle->save($raffle))
			{
				$this->__setFlash('Ganhador registrado!', 'success');
				$this->redirect('index');
			}
		}

		$awards = $this->Raffle->Award->find('list');
		$awards[0] = __('Selecione um sorteio');
		ksort($awards, SORT_NUMERIC);
		$this->set('awards', $awards);
	}

	public function delete($id = null) 
	{
	}

	public function admin_ajaxGetWinner()
	{
		if ($this->request->is('ajax')) 
		{
			$reincident = $this->request->query['reincident'];

			$winner = $this->Raffle->random($reincident);	

			$this->set('data', $winner);
			$this->viewPath = 'Elements';
			$this->layout = null;
			$this->render('json');
		}
	}
}
