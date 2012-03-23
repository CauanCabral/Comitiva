<?php
Configure::write('debug', 0);

define('LOG_ERROR', 2);
Configure::write('Error', array(
	'handler' => 'ErrorHandler::handleError',
	'level' => E_ALL & ~E_DEPRECATED,
	'trace' => true
));

Configure::write('Exception', array(
	'handler' => 'ErrorHandler::handleException',
	'renderer' => 'ExceptionRenderer',
	'log' => true
));

Configure::write('App.encoding', 'UTF-8');

Configure::write('Routing.prefixes', array('admin', 'participant', 'speaker'));


Configure::write('Session', array(
	'defaults' => 'php',
	'cookie' => 'COMITIVA'
));

Configure::write('Security.level', 'medium');

Configure::write('Security.salt', '79271b7807b063cbc7388e8ab65b3c842d1588c5');

Configure::write('Security.cipherSeed', '326163376438396365623339313639');

Configure::write('Acl.classname', 'DbAcl');
Configure::write('Acl.database', 'default');

$engine = 'File';
if (extension_loaded('apc') && function_exists('apc_dec') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
	$engine = 'Apc';
}

$duration = '+999 days';
if (Configure::read('debug') >= 1) {
	$duration = '+10 seconds';
}

$prefix = 'comitiva_';

Cache::config('_cake_core_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_core_',
	'path' => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));