<?php
App::uses('Sanitize', 'Utility');

class EventsController extends AppController
{

	public $name = 'Events';

	public $uses = array('Event');

	public $helpers = array('TinyMCE.TinyMCE');

	/**
	 * Ação pública para visualização das
	 * informações do evento.
	 *
	 * @return void
	 */
	public function view($slug = '')
	{
		$event = $this->Event->find('first', array(
			'conditions' => array('Event.alias' => $slug)
			)
		);

		if(empty($event))
		{
			$this->__setFlash('Evento inválido.', 'error');
			//$this->redirect('/');
		}

		$this->set(compact('event'));
	}

	/*
	 *  Ações para rota administrativa
	 */
	public function admin_index()
	{
		$this->Event->recursive = 0;

		$this->paginate = array(
			'conditions' => array(
				'OR' => array(
					'Event.parent_id ' => 0,
					'Event.parent_id IS NULL'
				)
			)
		);

		$this->set('events', $this->paginate());
	}

	public function admin_view($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Evento inválido', 'error');
			$this->redirect(array('action' => 'index'));
		}

		$this->set('event', $this->Event->read(null, $id));
	}

	public function admin_add()
	{
		if (!empty($this->request->data))
		{
			// removo variáveis de controle
			if(isset($this->request->data['EventPrice']['counter']))
				unset($this->request->data['EventPrice']['counter']);

			if(isset($this->request->data['EventDate']['counter']))
				unset($this->request->data['EventDate']['counter']);

			if($this->Event->add($this->request->data))
			{
				$this->__setFlash('Novo evento salvo!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('Novo evento não pode ser salvo. Tente novamente.');
		}

		$events = $this->Event->find('list');
		$this->set(compact('events'));
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->__setFlash('Evento inválido', 'error');
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->request->data))
		{
			// removo variáveis de controle
			if(isset($this->request->data['EventPrice']['counter']))
				unset($this->request->data['EventPrice']['counter']);

			if(isset($this->request->data['EventDate']['counter']))
				unset($this->request->data['EventDate']['counter']);

			if ($this->Event->add($this->request->data))
			{
				$this->__setFlash('Evento atualizado!', 'success');
				$this->redirect(array('action' => 'index'));
			}

			$this->__setFlash('O evento não pode ser salvo. Tente novamente.');
		}

		if (empty($this->request->data))
		{
			$this->request->data = $this->Event->find('first', array('conditions' => array('Event.id' => $id)));
		}

		$events = $this->Event->find('list');
		$this->set(compact('events'));
	}

	public function admin_delete($id = null)
	{
		if (!$id)
			$this->__setFlash('Id de evento inválido.', 'error');
		if ($this->Event->delete($id))
			$this->__setFlash('Evento apagado!', 'success');
		else
			$this->__setFlash('Evento não foi apagado!', 'error');

		$this->__goBack();
	}

	/*
	 *  Ações para rota de participante
	 */
	public function participant_index()
	{
		$this->Event->recursive = 0;

		$this->paginate = array(
			'conditions' => array(
				'OR' => array(
					'Event.parent_id ' => 0,
					'Event.parent_id IS NULL'
				)
			)
		);

		$events = $this->paginate();

		foreach ($events as &$event)
		{
			// atualiza situação do evento, se necessário
			$event['Event']['open'] = $this->Event->openToSubscription($event['Event']['id'], $event);
		}

		$this->set(compact('events'));
	}

	public function participant_view($id = null)
	{
		if (!$id)
		{
			$this->__setFlash('Evento inválido', 'error');
			$this->redirect(array('action' => 'index'));
		}

		$this->set('event', $this->Event->read(null, $id));
	}

	/*
	 * Ações assíncronaas (admin)
	 */

	public function admin_eventDateAdd()
	{
		$this->viewPath = '/Elements/forms';

		if($this->request->is('ajax'))
		{
			$this->__prepareAjax();
			$i = 0;

			if(isset($this->request->query['lastDateIndex']) && $this->request->query['lastDateIndex'] != null)
			{
				$i = Sanitize::paranoid($this->request->query['lastDateIndex']);
			}

			$this->set('i', $i);

			$this->render('event_date_add');
			return;
		}

		if(isset($this->passedArgs['index']) && is_numeric($this->passedArgs['index']))
		{
			$this->set('i', $this->passedArgs['index']);

			if(isset($this->passedArgs['id']) && is_numeric($this->passedArgs['id']))
			{
				$this->set('id', $this->passedArgs['id']);

				// recupera do banco os dados da data
				$eventDate = $this->Event->EventDate->find('first', array('recursive' => -1, 'conditions' => array('EventDate.id' => $this->passedArgs['id'])));

				// formata para utilização na view
				$output = array('EventDate' => array(
						$this->passedArgs['index'] => array(
							'id' => $eventDate['EventDate']['id'],
							'date' => $eventDate['EventDate']['date'],
							'time' => $eventDate['EventDate']['time'],
							'desc' => $eventDate['EventDate']['desc']
						)
					)
				);

				$this->request->data = $output;
			}

			$this->render('event_date_add');
			return;
		}

		throw new CakeException(__('Requisição inválida.'));
	}

	/**
	 * @todo implementar remoção de data
	 *
	 * @return unknown_type
	 */
	public function admin_eventDateDelete()
	{
		if($this->request->is('ajax'))
		{

		}
	}

	public function admin_eventPriceAdd()
	{
		$this->viewPath = '/Elements/forms';

		if($this->request->is('ajax'))
		{
			$i = 0;
			$this->__prepareAjax();

			if(isset($this->request->query['lastPriceIndex']) && $this->request->query['lastPriceIndex'] != null)
			{
				$i = Sanitize::paranoid($this->request->query['lastPriceIndex']);
			}

			$this->set('i', $i);

			$this->render('event_price_add');
			return;
		}

		if(isset($this->passedArgs['index']) && is_numeric($this->passedArgs['index']))
		{
			$this->set('i', $this->passedArgs['index']);

			if(isset($this->passedArgs['id']) && is_numeric($this->passedArgs['id']))
			{
				$this->set('id', $this->passedArgs['id']);

				$eventPrice = $this->Event->EventPrice->find('first', array('recursive' => -1, 'conditions' => array('EventPrice.id' => $this->passedArgs['id'])));

				// formata para utilização na view
				$output = array('EventPrice' => array(
					$this->passedArgs['index'] => $eventPrice['EventPrice']
					)
				);

				$this->request->data = $output;
			}

			$this->render('event_price_add');
			return;
		}

		throw new CakeException(__('Requisição inválida.'));
	}

	/**
	 * @todo implementar remoção de preço
	 *
	 * @return unknown_type
	 */
	public function admin_eventPriceDelete()
	{
		if($this->request->is('ajax'))
		{

		}
	}
}