<!DOCTYPE HTML>
<html  lang="pt-br">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('Comitiva: '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//========================= Estilos

		echo $this->Html->css('jquery/ui');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-responsive.min');
		echo $this->Html->css('comitiva');
		echo $this->Html->css('font-awesome');

		// ======================== Meta, Css e Scripts via Cake
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid">
			<div id="header">
				<h1><?php echo $this->Html->link(__('Comitiva: Sistema de controle de eventos'), 'http://phpms.org', array('title' => __('Copyright© Grupo de Usuários PHP de Mato Grosso do Sul - PHPMS'))); ?></h1>
			</div>

			<div id="content" class="row-fluid">
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

			<div id="footer" class="well">
				<?php echo $this->element('footer'); ?>
			</div>
		</div>
	</div>
	<?php
		// include js generated code
		echo $this->Js->writeBuffer();
	?>
</body>
</html>