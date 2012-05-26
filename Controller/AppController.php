<?php
App::uses('CakeEmail', 'Network/Email');
/**
 * PHP versions 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Comitiva : Sistema de gerenciamento de eventos ( http://comitiva.phpms.org )
 * Copyright 2010-2012, Grupo de Desenvolvedores PHP de Mato Grosso do Sul - PHPMS ( http://phpms.org )
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @copyright     Copyright 2010-2012, Grupo de Desenvolvedores PHP de Mato Grosso do Sul - PHPMS ( http://phpms.org )
 * @link          http://comitiva.phpms.org Comitiva Project
 * @package       Comitiva
 * @subpackage    Comitiva.Controller
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Controler base para o restante da aplicação.
 * Fornece vários métodos auxiliares para toda a aplicação.
 *
 * @package       Comitiva
 * @subpackage    Comitiva.Controller
 */
class AppController extends Controller
{
	/***********************************
	 * Propriedades do Controller
	 **********************************/

	public $components = array(
		'Auth',
		'Session',
		'DebugKit.Toolbar'
	);

	public $helpers = array(
		'Session',
		'Js',
		'Locale.Locale',
		'Html'		=> array('className' => 'TwitterBootstrap.BootstrapHtml'),
		'Form'		=> array('className' => 'TwitterBootstrap.BootstrapForm'),
		'Paginator'	=> array('className' => 'TwitterBootstrap.BootstrapPaginator'),
	);

	public $paginate = array('limit' => 50);

	/************************
	 * Atributos adicionais
	 ***********************/

	/**
	 * Reference for current user
	 *
	 * @var User
	 */
	public $activeUser = null;

	/*************************
	 * Cake Callbacks
	 ************************/

	/**
	 *
	 * @return void
	 */
	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->__setupAuth();

		if(!empty($this->activeUser)) {
			$this->__buildMenu();
		}
	}

	/**
	 *
	 * @return void
	 */
	public function beforeRender()
	{
	}

	public function isAuthorized()
	{
		if (empty($this->activeUser))
			return false;

		if (preg_match('/^estatica\//', $this->request->url) !== false)
			return true;

		if(isset($this->request->params['prefix']) && $this->__checkGroup($this->request->params['prefix']) )
			return true;

		return false;
	}

	/***************************
	 * Métodos auxiliares
	 **************************/

	private function __setupAuth()
	{
		$this->Auth->authenticate = array('Form');

		$this->Auth->authorize = array('Controller');

		if(!$this->__needLogin())
			$this->Auth->allow('*');

		$this->Auth->autoRedirect = false;
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'participant' => false);
		$this->Auth->logoutRedirect = '/';
		$this->Auth->loginRedirect = '/estatica/logged';

		$this->Auth->flash['params'] = array('class' => 'alert alert-info');
		$this->Auth->loginError = __('Falha no login. Por favor, verifique se o usuário e senha digitado estão corretos.');
		$this->Auth->authError = __('Desculpe, você precisa estar autenticado para acessar esta página.');

		$this->activeUser = $this->Auth->user();

		if(!empty($this->activeUser))
		{
			// Define user information in view class
			$this->set('activeUser', $this->activeUser);

			if($this->request->here == '/')
				$this->redirect('/estatica/logged');
		}
		else
		{
			$this->layout = 'login';
		}
	}

	/**
	 * TODO make this a dynamic menu generate
	 *
	 * @return unknown_type
	 */
	private function __buildMenu()
	{
		$menu = array();

		if($this->__checkGroup('admin'))
		{
			$menu = array(
				__('Eventos') => array(
					'controller' => 'events',
					'action' => 'index',
					'admin' => true
				),
				__('Pagamentos') => array(
					'controller' => 'payments',
					'action' => 'index',
					'admin' => true
				),
				__('Usuários') => array(
					'controller' => 'users',
					'action' => 'index',
					'admin' => true
				),
				__('Mensagens') => array(
					'controller' => 'messages',
					'action' => 'index',
					'admin' => true
				),
				__('Propostas') => array(
					'controller' => 'proposals',
					'action' => 'index',
					'admin' => true
				),
				__('Premiações') => array(
					'controller' => 'awards',
				 	'action' => 'index',
				 	'admin' => true
				),
				__('Sorteios') => array(
					'controller' => 'raffles',
				 	'action' => 'index',
				 	'admin' => true
				),
				__('Minha conta') => array(
					'controller' => 'users',
					'action' => 'profile',
					'admin' => true
				),
				__('Sair') => '/logout',
			);
		}
		else if($this->__checkGroup('participant'))
		{
			$menu = array(
				__('Eventos') => array(
					'controller' => 'events',
					'action' => 'index',
					'participant' => true
				)
			);

			// if($this->__checkGroup('speaker'))
			// {
			// 	$menu[__('Propostas')] = array(
			// 			'controller' => 'proposals',
			// 			'action' => 'index',
			// 			'speaker' => true
			// 	);
			// }
			// else
			// {
			// 	$menu[__('Propostas')] = array(
			// 			'controller' => 'proposals',
			// 			'action' => 'add',
			// 			'participant' => true
			// 	);
			// }

			$menu[__('Minha conta')] = array(
				'controller' => 'users',
				'action' => 'profile',
				'participant' => true
			);

			$menu[__('Sair')] = array(
				'controller' => 'users',
				'action' => 'logout',
				'admin' => false,
				'participant' => false,
				'speaker' => false
			);
		}

		$this->set('menuItems', $menu);
	}

	/**
	 * Método auxiliar para verificar se um determinado usuário
	 * pertence a um determinado grupo.
	 *
	 * @param string $group
	 * @param array $user_groups optional
	 *
	 * @return bool true caso pertença, false caso contrário
	 */
	protected function __checkGroup($group, $user_groups = null)
	{
		if($user_groups == null)
			$groups = json_decode($this->activeUser['groups'], true);
		else
			$groups = $user_groups;

		foreach($groups as $g)
		{
			$tmp = str_replace('"', '', $g);

			if($tmp === $group)
				return true;
		}

		return false;
	}

	protected function __needLogin()
	{
		if( isset($this->request->params['prefix']) && in_array($this->request->params['prefix'], Configure::read('Routing.prefixes')) )
			return true;

		if( preg_match('/^estatica\//', $this->request->url) !== false )
			return true;

		return false;
	}

	/**
	 * Preparação para resposta Ajax
	 */
	protected function __prepareAjax($autoRender = false)
	{
		Configure::write('debug', 0);

		$this->layout = 'ajax';

		$this->autoRender = $autoRender;
	}

	protected function __setFlash($message, $class)
	{
		if(strpos($class, 'alert') === false)
			$class = 'alert-' . $class;

		$this->Session->setFlash(__($message), 'alert', array('plugin' => 'TwitterBootstrap', 'class' => $class));
	}

	/**
	 * Redireciona para última ação vista
	 *
	 * @return void
	 */
	protected function __goBack()
	{
		// caso a página anterior seja diferente da página atual
		if($this->referer() != $this->request->here)
		{
			// tenta redirecionar de volta para tela anterior, caso não consiga manda par action index
			$this->redirect($this->referer(array('action'=>'index'), true));
		}

		// redireciona para a index do controller atual para evitar erro de redirecionamento
		$this->redirect(array('action' => 'index'));
	}

	protected function __sendMailNotification($to, $subject, $tmpl, $body = null)
	{
		$email = new CakeEmail('default');

		$email->to($to)
				->subject($subject)
				->replyTo(Configure::read('Message.replyTo'))
				->from(Configure::read('Message.from'))
				->emailFormat('html')
				->viewVars($this->viewVars);

		if($body !== null)
			$email->body($body);
		else
			$email->template($tmpl);

		return $email->send();
	}
}