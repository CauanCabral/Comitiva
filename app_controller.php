<?php
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller
{
	/****************************
	 * Cake Controller atributes
	 ****************************/
	
	public $components = array('Auth', 'RequestHandler', 'Session');
	
	public $helpers = array('Html', 'Form', 'Session');
	
	public $uses = array(); // ATENÇÃO! não carregue modelos no  AppController. Em último caso utilize Controller::loadModel
	
	
	/************************
	 * Aditional atributes
	 ***********************/
	
	/**
	 * TRUE if user has logged
	 * 
	 * @var boolean
	 */
	public $userLogged = false;
	
	
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
	
	
	/***************************
	 * Auxiliar methods
	 **************************/
	
	private function __setupAuth()
	{
		//Configure AuthComponent
		$this->Auth->authorize = 'controller';

		$this->Auth->allowedActions = array('logout', 'login');

		if( !isset($this->params['prefix']) || !( in_array($this->params['prefix'], Configure::read('Routing.prefixes')) ) )
		{
			// all non-prefixed actions are allowed
			$this->Auth->allow('*');
		}
		
		$this->Auth->allow('*');

		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'prefix' => '');
		$this->Auth->logoutRedirect = array('controller' => 'pages', 'action' => 'index', 'prefix' => '');
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'profile', 'prefix' => '');

		// What to say when the login was incorrect.
		$this->Auth->loginError = __('Falha no login. Por favor, verifique se o usuário e senha digitado estão corretos.', 1);
		// What to say when unauthorized access has detected
		$this->Auth->authError = __('Desculpe, você precisa estar autenticado para acessar esta página.', 1);
		
		// Define a static access to user information
		App::import('Model', 'User');
		User::store($this->Auth->user());
		
		// Define flag to indique logged user
		$this->userLogged = true;

		// Define user information in view class
		$this->set('activeUser', $this->Auth->user());
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
			//$this->layout = 'error';
		}
	}
}
?>