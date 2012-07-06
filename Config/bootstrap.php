<?php
// Definição de locale para formatar saída de Data, Hora, moedas e etc
setlocale(LC_ALL, 'pt_BR.utf-8', 'pt_BR', 'pt-br', 'pt', 'pt_BR.iso-8859-1', 'portuguese');

// Definição de variável de localização para uso no sistema
Configure::write('Config.language', 'pt_br');
Configure::write('Language.default', 'pt-br');

// Definição do email utilizado para enviar mensagens
Configure::write('Message.from', array('admin@phpms.org' => 'PHPMS'));

// Email para retorno
Configure::write('Message.replyTo', 'admin@phpms.org');

// Nome abreviado da aplicação/organizador
Configure::write('Comitiva.name', 'PHPMS');

// Nome completo da aplicação/organizador
Configure::write('Comitiva.fullName', 'PHPMS - Grupo de Desenvolvedores PHP de Mato Grosso do Sul.');

// Informações gerais sobre as formas de pagamento
Configure::write('Comitiva.paymentInfo', '');

Configure::write('Comitiva.googleApiLibs', array(
	'jquery' => '1.7',
	'jqueryui' => '1.8'
));

Configure::write('PagSeguro', array(
    'email' => 'COLOQUE UM EMAIL VALIDO',
    'token' => 'COLOQUE UM TOKEN VALIDO'
));

// Configurações do Cake 2.2
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));

CakeLog::config('debug', array(
    'engine' => 'FileLog',
    'types' => array('notice', 'info', 'debug'),
    'file' => 'debug',
));
CakeLog::config('error', array(
    'engine' => 'FileLog',
    'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
    'file' => 'error',
));

CakePlugin::loadAll();

/*
 * Include local bootstrap, only for settings specify enviroment (local machine of developer or production)
 */
if(file_exists(APP . 'Config' . DS . 'bootstrap.local.php'))
{
	include(APP . 'Config' . DS . 'bootstrap.local.php');
}