<?php
// Definição de locale para formatar saída de Data, Hora, moedas e etc
setlocale(LC_ALL, 'pt_BR.utf-8', 'pt_BR', 'pt-br', 'pt', 'pt_BR.iso-8859-1', 'portuguese');

// Definição de variável de localização para uso no sistema
Configure::write('Config.language', 'pt_br');
Configure::write('Language.default', 'pt-br');

// Definição do email utilizado para enviar mensagens
Configure::write('Message.from', array('admin@phpms.org' => 'PHPMS'));

Configure::write('Message.replyTo', 'admin@phpms.org');

//
Configure::write('Comitiva.name', 'PHPMS');

Configure::write('Comitiva.fullName', 'PHPMS - Grupo de Desenvolvedores PHP de Mato Grosso do Sul.');

Configure::write('Comitiva.googleApiLibs', array(
	'jquery' => '1.7',
	'jqueryui' => '1.8'
));

CakePlugin::loadAll();

/*
 * Include local bootstrap, only for settings specify enviroment (local machine of developer or production)
 */
if(file_exists(APP . 'Config' . DS . 'bootstrap.local.php'))
{
	include(APP . 'Config' . DS . 'bootstrap.local.php');
}