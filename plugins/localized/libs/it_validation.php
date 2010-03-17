<?php
/**
 * Italian Localized Validation class. Handles localized validation for Italy
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
 * @link          http://cakephp.org
 * @package       localized
 * @subpackage    localized.libs
 * @since         Localized Plugin v 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * ItValidation
 *
 * @package       localized
 * @subpackage    localized.libs
 */
class ItValidation {

/**
 * Checks phone numbers for Italy
 *
 * @param string $check The value to check.
 * @return boolean
 * @access public
 */
	function phone($check) {
		$pattern = '/^([0-9]*\-?\ ?\/?[0-9]*)$/';
		return preg_match($pattern, $check);
	}

/**
 * Checks zipcodes for Italy
 *
 * @param string $check The value to check.
 * @return boolean
 * @access public
 */
	function postal($check) {
		$pattern = '/^[0-9]{5}$/i';
		return preg_match($pattern, $check);
	}
}
?>