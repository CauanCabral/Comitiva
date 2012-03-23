<?php
$libs = Configure::read('Comitiva.googleApiLibs');
$script = '';

foreach($libs as $lib => $version)
{
	$script .= 'google.load("'. $lib .'", "'. $version .'");';
}

echo $this->Html->scriptBlock($script);