<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo __('Comitiva'), ': ', __d('title', $title_for_layout); ?></title>
	<?php
		echo $this->Html->meta('icon');

		// Carrega o Google API Loader
		echo $this->Html->script('https://www.google.com/jsapi');
		// Carrega os scripts disponíveis via Google CDN
		echo $this->element('google_loader');

		//========================= Scripts

		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('bootstrap-datepicker');
		echo $this->Html->script('ui');

		//========================= Estilos

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-responsive.min');
		echo $this->Html->css('datepicker');
		echo $this->Html->css('font-awesome');
		echo $this->Html->css('comitiva');

		// ======================== Meta, Css e Scripts via Cake
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid">
			<div id="header">
				<h1><?php echo $this->Html->link(__('Comitiva: Sistema de controle de eventos'), 'http://phpms.org', array('title' => __('Copyright© Grupo de Usuários PHP de Mato Grosso do Sul - PHPMS'))); ?></h1>
			</div>

			<div id="content" class="row-fluid">
				<?php
				echo $this->element('alerts');

				echo $this->fetch('content');
				?>
			</div>

			<div id="footer" class="well">
				<?php echo $this->element('footer'); ?>
			</div>
		</div>
	</div>
	<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>