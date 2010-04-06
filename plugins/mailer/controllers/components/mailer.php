<?php
/**
 * @FIXME utilizar a classe App para importar a lib externa
 */
require_once('plugins' . DS . 'mailer' . DS . 'vendors' . DS . 'swiftmailer' . DS . 'lib' . DS . 'swift_required.php');

class MailerComponent extends Object
{
	protected $controller = null;
	
	protected $transport = null;
	
	protected $message = null;
	
	protected $options = array(
		'transport' => 'php', //valid options are: php, sendmail and smtp
		'batch' => true, // if use batch send mode or not
		'contentType' => 'html', //valid options are: html and text
		'template' => 'default', // path for body theme
		'layout' => 'default',
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
	function initialize($controller, $settings = array())
	{
		// saving the controller reference for later use
		$this->controller = $controller;
		
		$this->options = Set::merge($this->options, $settings);
		
		if($this->options['layout'])
			$this->layout = $this->options['layout'];
			
		if($this->options['template'])
			$this->template = $this->options['template'];
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
			trigger_error(__('Falha na configuração do transporte', TRUE), E_USER_WARNING);
			return FALSE;
		}
		
		if(!$this->__setMessageOptions($options))
		{
			trigger_error(__('Falha na definição da mensagem', TRUE), E_USER_WARNING);
			return FALSE;
		}
		
		if($this->options['batch'])
			return $this->transport->batchSend($this->message);
		else
			return $this->transport->send($this->message);
	}
	
	/**************** End utils funcions ****************/
	
	
	/****************** Begin setters *******************/
	public function setMessageSubject($value)
	{
		if($this->message === null)
		{
			trigger_error(__('Não é possível setar uma propriedade antes de criar uma mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
		
		$this->message->setSubject($value);
		
		return TRUE;
	}
	
	public function setMessageBody($value)
	{
		if($this->message === null)
		{
			trigger_error(__('Não é possível setar uma propriedade antes de criar uma mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
		
		$this->message->setBody($this->__render($value));
		
		return TRUE;
	}
	
	public function setMessagePart($value)
	{
		if($this->message === null)
		{
			trigger_error(__('Não é possível setar uma propriedade antes de criar uma mensagem', TRUE), E_USER_ERROR);
			
			return FALSE;
		}
		
		$this->message->setPart($value);
		
		return TRUE;
	}
	
	/******************* End setters *********************/
	
	/*************** Begin internal utils ****************/
	
	private function __initMessage()
	{
		if($this->message === null)
		{
			$this->message = Swift_Message::newInstance();
			
			return ($this->message != null);
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
		$status = TRUE;
		
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
			$status = ($status && $this->message->setCc($options['cc']));
		}
		
		// define blind carbon-copy mails
		if(isset($options['bcc']))
		{
			$status = ($status && $this->message->setBcc($options['bcc']));
		}
		
		// define message content
		if(isset($options['body']))
		{
			var_dump($status);
			$status = ($status && $this->setMessageBody($options['body']));
			var_dump($status);
		}
		
		return $status;
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
			trigger_error(__('Camada de transporte inválida', TRUE), E_USER_ERROR);
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * Render the contents using the current layout and template.
	 * Based on EmailComponent, part of CakePHP Framework
	 * 
	 * @copyright EmailComponent: CakePHP Foundation
	 * @link http://cakephp.org
	 * @subpackage cake.libs.controllers.components.email
	 * @license MIT
	 * 
	 * @param string $content Content to render
	 * @return array Email ready to be sent
	 * @access private
	 */
	private function __render($content)
	{
		$body = '';
		
		$viewClass = $this->controller->view;
		
		if ($viewClass != 'View')
		{
			list($plugin, $viewClass) = pluginSplit($viewClass);
			$viewClass = $viewClass . 'View';
			App::import('View', $this->controller->view);
		}

		$View = new $viewClass($this->controller, true);
		$View->layout = $this->layout;
		
		if (is_array($content))
		{
			$content = implode("\n", $content) . "\n";
		}
				
		if ($this->options['contentType'] === 'html') 
		{
			$View->layoutPath = 'email' . DS . 'html';
			
			$body = $View->element('email' . DS . 'html' . DS . $this->template, array('content' => $content), true);
			
			$body = str_replace(array("\r\n", "\r"), "\n", $View->renderLayout($body));
		}
		else if ($this->options['contentType'] === 'text')
		{
			$View->layoutPath = 'email' . DS . 'text';
			
			$body = $View->element('email' . DS . 'text' . DS . $this->template, array('content' => $content), true);

			$body = str_replace(array("\r\n", "\r"), "\n", $View->renderLayout($content));
		}
		
		return $body;
	}
}
?>