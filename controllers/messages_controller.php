<?php
App::import('CORE', 'Sanitize');

class MessagesController extends AppController
{
	public $uses = array('Message');
	
	public $components = array('Mailer.Mailer');
	
	public $helpers = array('TinyMce.TinyMce');

	public function isAuthorized()
	{
		if($this->userLogged == TRUE && $this->params['prefix'] == User::get('type'))
		{
			return true;
		}
		
		return false;
	}
	
	public function admin_sendInvitation()
	{
		// caso a mensagem tenha sido fornecida
		if(!empty($this->data))
		{
			$this->loadModel('Subscription');
			
			$op = array(
				'from' => 'cauan@radig.com.br',
				'to' => 'cauanc@gmail.com',
				'body' => 'Texto podre'
			);
			
			if($this->Mailer->sendMessage($op))
			{
				$this->Session->setFlash(__('Convite enviado', TRUE));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Falha no envio', TRUE));
			}
		}
		
		// carrega e seta a lista de eventos cadastrado para usuário selecionar
		$this->loadModel('Event');
		$this->set('events', $this->Event->find('list'));
	}
	
	/**
	 * Envia uma mensagem, utilizando os dados setados no atributo da classe MessagesController::data
	 * 
	 * @return unknown_type
	 */
	protected function sendMessage()
	{
		
	}
}