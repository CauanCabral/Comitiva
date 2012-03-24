<?php
$this->TinyMCE->editor(array(
		'mode' => 'textareas',
		'language' => 'pt',
		'theme' => 'advanced',
		'theme_advanced_toolbar_location' => 'top',
		'theme_advanced_toolbar_align' => 'left',
		'theme_advanced_buttons1' => 'fontsizeselect,separator,bold,italic,separator,undo,redo,separator,bullist,forecolor,cleanup,removeformat',
		'theme_advanced_buttons2' => '',
		'theme_advanced_buttons3' => '',
		'theme_advanced_font_sizes' => "5pt,7pt,12pt,16pt,18pt",
		'theme_advanced_resizing' => true,
		'skin' => 'o2k7',
		'skin_variant' => 'silver',
		'width' => '80%',
		'content_css' => '/css/tiny_mce_content.css',
	)
);