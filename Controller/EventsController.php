<?php
App::uses('Sanitize', 'Utility');

class EventsController extends AppController
{

	public $name = 'Events';
	
	public $uses = array('Event');
	
	public $helpers = array('TinyMCE.TinyMCE');
	
	/*
	 *  Ações para rota administrativa
	 */
	public function admin_index()
	{
		$this->Event->recursive = 0;
		
		// list just root events
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
			$this->Session->setFlash(__('Evento inválido'), 'default', array('class' => 'attention'));
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
				
			if ($this->Event->add($this->request->data))
			{
				$this->Session->setFlash(__('Novo evento salvo!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{	
				$this->Session->setFlash(__('Novo evento não pode ser salvo. Tente novamente.'), 'default', array('class' => 'attention'));
			}
		}
		
		$events = $this->Event->find('list');
		$this->set(compact('events'));
	}

	public function admin_edit($id = null)
	{
		if (!$id && empty($this->request->data))
		{
			$this->Session->setFlash(__('Evento inválido'), 'default', array('class' => 'attention'));
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
				$this->Session->setFlash(__('Evento atualizado!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('O evento não pode ser salvo. Tente novamente.'), 'default', array('class' => 'attention'));
			}
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
		{
			$this->Session->setFlash(__('Id de evento inválido.'), 'default', array('class' => 'attention'));
		}
		if ($this->Event->delete($id))
		{
			$this->Session->setFlash(__('Evento apagado!'), 'default', array('class' => 'success'));
		}
		else
		{
			$this->Session->setFlash(__('Evento não foi apagado!'), 'default', array('class' => 'attention'));
		}
		
		$this->__goBack();
	}
	
	/*
	 *  Ações para rota de participante
	 */
	public function participant_index()
	{
		$this->Event->recursive = 0;
		
		// list just root events
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

	public function participant_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Evento inválido'), 'default', array('class' => 'attention'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('event', $this->Event->read(null, $id));
	}
	
	/*
	 * Ações assíncronaas (admin)
	 */
	
	public function admin_eventDateAdd()
	{
		$this->viewPath = '/elements/forms';
		
		if($this->RequestHandler->isAjax())
		{
			$this->__prepareAjax();
			
			if(isset($this->request->params['url']['lastDateIndex']) && $this->request->params['url']['lastDateIndex'] != null)
			{
				$i = Sanitize::paranoid($this->request->params['url']['lastDateIndex']);
			}
			else
			{
				$i = 0;
			}
			
			$this->set('i', $i);
			
			$this->render('event_date_add');
		}
		else if(isset($this->passedArgs['index']) && is_numeric($this->passedArgs['index']))
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
							'desc' => $eventDate['EventDate']['desc']
						)
					)
				);
				
				$this->request->data = $output;
			}
			
			$this->render('event_date_add');
		}
	}
	
	/**
	 * TODO implementar remoção de data
	 * 
	 * @return unknown_type
	 */
	public function admin_eventDateDelete()
	{
		if($this->RequestHandler->isAjax())
		{
			
		}
	}
	
	public function admin_eventPriceAdd()
	{
		$this->viewPath = '/elements/forms';
		
		if($this->RequestHandler->isAjax())
		{
			$this->__prepareAjax();
			
			if(isset($this->request->params['url']['lastPriceIndex']) && $this->request->params['url']['lastPriceIndex'] != null)
			{
				$i = Sanitize::paranoid($this->request->params['url']['lastPriceIndex']);
			}
			else
			{
				$i = 0;
			}
			
			$this->set('i', $i);
			
			$this->render('event_price_add');
		}
		else if(isset($this->passedArgs['index']) && is_numeric($this->passedArgs['index']))
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
		}
	}
	
	/**
	 * TODO implementar remoção de preço
	 * 
	 * @return unknown_type
	 */
	public function admin_eventPriceDelete()
	{
		if($this->RequestHandler->isAjax())
		{
			
		}
	}
	
}
?>