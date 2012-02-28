<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/* Definição de timezone pra poder usar a classe DateTime e manter compatibilidade com PHP 5.3 */
date_default_timezone_set('America/Campo_Grande');

/* Definição de locale para formatar saída de Data, Hora, moedas e etc */
setlocale(LC_ALL, 'pt_BR.utf-8', 'pt_BR', 'pt-br', 'pt', 'pt_BR.iso-8859-1', 'portuguese');

/* Definição de variável de localização para uso no sistema */
Configure::write('Config.language', 'pt_br');

/* Definição do email utilizado para enviar mensagens */
Configure::write('Message.from', 'admin@phpms.org');

/*
 * Include local bootstrap, only for settings specify enviroment (local machine of developer or production)
 */
if(file_exists(APP . 'Config' . DS . 'bootstrap.local.php'))
{
	include(APP . 'Config' . DS . 'bootstrap.local.php');
}
?>