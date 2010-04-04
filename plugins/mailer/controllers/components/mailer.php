<?php
App::import('Vendor', 'swift_required', array('file' => 'swiftmailer' . DS . 'lib' . DS . 'swift_required.php'));

class MailerComponent extends Object
{
	protected $transport = null;
	
	protected $message = null;
	
	protected $defaultOptions = array(
		'transport' => 'php', //valid options are: php, sendmail and smtp
		'contentType' => 'html', //valid options are: html and text
		'viewPath' => null, // path for body theme
		'smtp' => array(
			'port' => 25,
			'host' => 'localhost'
		),
		'sendmail' => array(
			'path' => '/usr/sbin/sendmail',
			'params' => ''
		) 
	);
	
	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array())
	{
		// saving the controller reference for later use
		$this->controller =& $controller;
	}

	//called after Controller::beforeFilter()
	function startup(&$controller)
	{
	}

	//called after Controller::beforeRender()
	function beforeRender(&$controller)
	{
	}

	//called after Controller::render()
	function shutdown(&$controller)
	{
	}

	//called before Controller::redirect()
	function beforeRedirect(&$controller, $url, $status=null, $exit=true)
	{
	}

	function redirectSomewhere($value)
	{
		// utilizing a controller method
		$this->controller->redirect($value);
	}
	
	/************** End callbacks section ***************/
	
	
	/*************** Begin utils funcions ***************/ 
	
	/**
	 * Send one or more message
	 * 
	 * @param array $options
	 * 	Valid optionas are:
	 * 	'to' - string or array with destiny mail address - REQUIRED
	 * 	'from' - string with sender mail address - REQUIRED
	 * 	'cc' - string or array with destiny mail address - OPTIONAL
	 *  'bcc' - string or array with destiny mail address - OPTIONAL
	 *  'body' - string - OPTIONAL
	 *  
	 * @return bool
	 */
	public function sendMessage($options = array())
	{
		if(empty($options))
		{
			trigger_error(__('$options não pode estar vazio', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
		
		if(!$this->__configureTransport())
		{
			return FALSE;
		}
		
		if(!$this->__setMessageOptions($options))
		{
			return FALSE;
		}
		
		$this->transport->send($this->message);
		
	}
	
	/**************** End utils funcions ****************/
	
	
	/****************** Begin setters *******************/
	
	public function setMessageHeader($value)
	{
		if($this->message === null)
		{
			trigger_error(__('Não é possível setar uma propriedade antes de criar uma mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
	}
	
	public function setMessageType($value)
	{
		if($this->message === null)
		{
			trigger_error(__('Não é possível setar uma propriedade antes de criar uma mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
	}
	
	public function setMessageSubject($value)
	{
		if($this->message === null)
		{
			trigger_error(__('Não é possível setar uma propriedade antes de criar uma mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
	}
	
	public function setMessageBody($value)
	{
		if($this->message === null)
		{
			trigger_error(__('Não é possível setar uma propriedade antes de criar uma mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
	}
	
	public function setMessagePart($value)
	{
		if($this->message === null)
		{
			trigger_error(__('Não é possível setar uma propriedade antes de criar uma mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
	}
	
	/******************* End setters *********************/
	
	/*************** Begin internal utils ****************/
	
	private function __initMessage()
	{
		if($this->message === null)
		{
			$this->message = Swift_Message::newInstance();
			
			return ($this->message == null);
		}
		
		return TRUE;
	}
	
	/**
	 * Set all passed options wich a message property
	 * If a proport is Required, but not defined in $options, method abort and return FALSE
	 * ELSE return TRUE
	 * 
	 * @param array $options - REQUIRED
	 * @return bool
	 */
	private function __setMessageOptions($options = array())
	{	
		if(!$this->__initMessage())
		{	
			trigger_error(__('Não é possível setar uma propriedade antes de criar uma mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
		
		// define destiny mail
		if(isset($options['to']))
		{
			$this->message->setTo($options['to']);
		}
		else
		{
			trigger_error(__('É preciso definir o destinatário da mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
		
		// define origin mail
		if(isset($options['from']))
		{
			$this->message->setFrom($options['from']);
		}
		else
		{
			trigger_error(__('É preciso definir o remetente da mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
		
		// define carbon-copy mails
		if(isset($options['cc']))
		{
			$this->message->setCc($options['cc']);
		}
		
		// define blind carbon-copy mails
		if(isset($options['bcc']))
		{
			$this->message->setBcc($options['bcc']);
		}
		
		// define message content
		if(isset($options['body']))
		{
			$this->setMessageBody($options['body']);
		}
		
		return $out;
	}
	
	/**
	 * Get from Mailer::options transport related params and
	 * init a Swift_Transport class
	 * 
	 * @return bool
	 */
	private function __configureTransport()
	{
		if($this->options['transport'] == 'smtp')
		{
			$this->transport =
				Swift_SmtpTransport::newInstance($this->options['smtp']['host'], $this->options['smtp']['port']);
				
			if(isset($this->options['smtp']['username']))
				$this->transport->setUsername($this->options['smtp']['username']);
				
			if(isset($this->options['smtp']['password']))
				$this->transport->setPassword($this->options['smtp']['password']);
		}
		else if($this->options['transport'] == 'sendmail')
		{
			$this->transport =
				Swift_SendmailTransport::newInstance($this->options['sendmail']['path'] . $this->options['sendmail']['params']);
		}
		else if($this->options['transport'] == 'php')
		{
			$this->transport = Swift_MailTransport::newInstance();
		}
		else
		{
			trigger_error(__('Camada de transporte inválido', TRUE), E_USER_ERROR);
			return FALSE;
		}
		
		return TRUE;
	}
}
?>