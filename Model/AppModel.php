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
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @copyright     Copyright 2010, Grupo de Desenvolvedores PHP de Mato Grosso do Sul - PHPMS ( http://phpms.org )
 * @link          http://comitiva.phpms.org Comitiva Project
 * @package       cake
 * @subpackage    cake.comitiva
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
	public $actsAs = array('Containable');
}