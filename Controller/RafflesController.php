<?php
App::uses('AppController', 'Controller');
/**
 * Raffles Controller
 *
 * @property Raffle $Raffle
 */
class RafflesController extends AppController
{
	public $helpers = array('TwitterBootstrap.BootstrapHtml', 'TwitterBootstrap.BootstrapForm', 'TwitterBootstrap.BootstrapPaginator');
	
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

	public function admin_delete($id = null) 
	{
		$this->Raffle->id = $id;
		
		if (!$this->Raffle->exists())
		{
			throw new NotFoundException('Premiado inexistente');
		}
		
		if ($this->Raffle->delete()) 
		{
			$this->Session->setFlash(
				__('Premiado excluído!'),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('Não foi possível excluir o premiado. Tente novamente'),
			'alert',
			array(
				'plugin' => 'TwitterBootstrap',
				'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}

	public function admin_ajaxGetWinner()
	{
		if ($this->request->is('ajax')) 
		{
			$reincident = $this->request->query['reincident'];
			$winner = $this->Raffle->random((bool)$reincident);	

			if( $winner === 0)
				 $winner = array('name' => 'Nenhum participante disponível', 'id' => 0);

			$this->set('data',  $winner);
			$this->viewPath = 'Elements';
			$this->layout = null;
			$this->render('json');
		}
	}
}
