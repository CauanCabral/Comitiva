<?php
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'index'));
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Alias for non-prefixed actions (hack for bug route in cake 1.3-dev)
 */
Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
Router::connect('/account_create', array('controller' => 'users', 'action' => 'account_create'));
Router::connect('/account_confirm/*', array('controller' => 'users', 'action' => 'account_confirm'));
Router::connect('/recover', array('controller' => 'users', 'action' => 'recover'));
Router::connect('/profile', array('controller' => 'users', 'action' => 'profile'));
Router::connect('/reset_password/*', array('controller' => 'users', 'action' => 'reset_password'));

/**
 * Administrators route
 */
Router::connect('/admin', array('controller' => 'users', 'action' => 'profile', 'prefix' => 'admin'));  

/**
 * Participants route
 */
Router::connect('/participant', array('controller' => 'users', 'action' => 'profile', 'prefix' => 'participant'));

?>