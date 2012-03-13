<?php
/**
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
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('Comitiva: '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');


		echo $this->Html->css('comitiva');
		echo $this->Html->css('menu');

		echo $this->Html->css('jquery/ui');

		echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
		echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js');

		// others
		echo $this->Html->script('menu');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link(__('Comitiva: Sistema de controle de eventos do PHPMS'), 'http://phpms.org'); ?></h1>
		</div>

		<?php if(isset($menuItems) && !empty($menuItems)): ?>
		<ul id="menu">
			<?php echo $this->element('menu', $menuItems); ?>
		</ul>
		<?php endif; ?>

		<div id="content">

			<?php
			if ($this->Session->check('Message.auth'))
			{
				echo $this->Session->flash('auth');
			}

			if ($this->Session->check('Message.error'))
			{
				echo $this->Session->flash('error');
			}

			if ($this->Session->check('Message.flash'))
			{
				echo $this->Session->flash();
			}
			?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $this->element('footer'); ?>
		</div>
	</div>
	<?php
		echo $this->Js->writeBuffer();
	?>
</body>
</html>