<?php
/**
 * PHP versions 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * 
 * Comitiva : Sistema de gerenciamento de eventos ( http://comitiva.phpms.org )
 * Copyright 2010, Grupo de Desenvolvedores PHP de Mato Grosso do Sul - PHPMS ( http://phpms.org )
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @copyright     Copyright 2010-2012, Grupo de Desenvolvedores PHP de Mato Grosso do Sul - PHPMS ( http://phpms.org )
 * @link          http://comitiva.phpms.org Comitiva Project
 * @package       cake
 * @subpackage    cake.comitiva
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Base of all Application Controllers
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.comitiva
 */
class AppController extends Controller
{
	/****************************
	 * Cake Controller atributes
	 ****************************/
	
	public $components = array(
		'Auth',
		'Session',
		'DebugKit.Toolbar'
		);
	
	public $helpers = array(
		'Session',
		'Html',
		'Form',
		'Js',
		'Locale.Locale'
		);
	
	public $paginate = array('limit' => 50);
	
	/************************
	 * Aditional atributes
	 ***********************/
	
	/**
	 * Reference for current user
	 * 
	 * @var User
	 */
	public $activeUser;
	/*************************
	 * Cake Callbacks
	 ************************/
	
	/**
	 * Callback default
	 * 
	 * @return void
	 */
	public function beforeFilter()
	{
		$this->__setupAuth();
		
		if($this->userLogged === true)
		{
			$this->__buildMenu();
		}
		
		parent::beforeFilter();
	}
	
	/**
	 * Callback default
	 * 
	 * @return void
	 */
	public function beforeRender()
	{
		$this->__setErrorLayout();
	}
	
	public function isAuthorized()
	{
		if($this->userLogged === TRUE && $this->__checkGroup($this->request->params['prefix']) )
		{
			return true;
		}
		
		return false;
	}
	
	/***************************
	 * Auxiliar methods
	 **************************/
	
	private function __setupAuth()
	{
		$this->Auth->authenticate = array('Form');
		
		$this->Auth->authorize = 'controller';

		if( !isset($this->request->params['prefix']) || !( in_array($this->request->params['prefix'], Configure::read('Routing.prefixes')) ) )
		{
			// all non-prefixed actions are allowed
			$this->Auth->allow('*');
		}

		$this->Auth->autoRedirect = false;
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'participant' => false);
		$this->Auth->logoutRedirect = '/';
		$this->Auth->loginRedirect = '/estatica/logged';

		// What to say when the login was incorrect.
		$this->Auth->loginError = __('Falha no login. Por favor, verifique se o usuário e senha digitado estão corretos.');
		// What to say when unauthorized access has detected
		$this->Auth->authError = __('Desculpe, você precisa estar autenticado para acessar esta página.');
		
		// tmp var to load logged user information
		$this->activeUser = $this->Auth->user();
		
		if($this->activeUser != null)
		{
			// Define user information in view class
			$this->set('activeUser', $this->activeUser);
			
			if($this->request->here == '/')
			{
				$this->redirect('/estatica/logged');
			}
		}
		else
		{
			// if not authenticated, alter display layout
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
		//$groups = json_decode(User::get('groups'), true);
		
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
			
			if($this->__checkGroup('speaker'))
			{
				$menu[__('Propostas')] = array(
						'controller' => 'proposals',
						'action' => 'index',
						'speaker' => true
				);
			}
			else
			{
				$menu[__('Propostas')] = array(
						'controller' => 'proposals',
						'action' => 'add',
						'participant' => true
				);
			}
			
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
		else
		{
			$menu = array();
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
	 * @return bool TRUE caso pertença, FALSE caso contrário
	 */
	protected function __checkGroup($group, $user_groups = null)
	{
		if($user_groups == null)
		{
			$groups = json_decode(User::get('groups'), true);
		}
		else
		{
			$groups = $user_groups;
		}
		
		foreach($groups as $g)
		{
			$tmp = str_replace('"', '', $g);
			
			if($tmp === $group)
				return true;
		}
		
		return false;
	} 
	
	/**
	 * Override Error Handling of CakePHP to use a proper layout file
	 * 
	 * @return void
	 */
	private function __setErrorLayout()
	{
		if($this->name == 'CakeError')
		{
			//@TODO create the error layout
			//$this->layout = 'error';
		}
	}
	
	/**
	 * This method prepare default a ajax response
	 */
	protected function __prepareAjax($autoRender = false)
	{
		Configure::write('Cache.disable', true);
		Configure::write('debug', 0);
		
		$this->autoRender = $autoRender;
	}
	
	/**
	 * Try redirect to origin action
	 * 
	 * @return void
	 */
	protected function __goBack()
	{
		// tenta redirecionar de volta para tela anterior, caso não consiga manda par action index
		$this->redirect($this->referer(array('action'=>'index'), TRUE));
	}
}