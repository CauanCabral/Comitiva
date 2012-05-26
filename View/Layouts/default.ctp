<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo __('Comitiva'), ' - ', __d('title', $title_for_layout); ?></title>
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

		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('jquery-ui.ie');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-responsive.min');
		echo $this->Html->css('datepicker');
		echo $this->Html->css('font-awesome');
		echo $this->Html->css('comitiva');

		// ======================== Meta, Css e Scripts via Cake
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

		echo $this->Html->scriptBlock('baseUrl= "' . Router::url('/', true) . '";');
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div class="container-fluid">
		<div id="header">
			<h1><?php echo $this->Html->link(__('Comitiva - Sistema de controle de eventos do PHPMS'), 'http://phpms.org'); ?></h1>
		</div>
		<div class="row-fluid" id="content">
			<?php if(isset($menuItems) && !empty($menuItems)): ?>
			<div class="row-fluid navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
						<?php echo $this->element('menu', $menuItems); ?>
						</ul>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<div class="row-fluid">
				<?php
				echo $this->element('alerts');

				echo $this->fetch('content');
				?>
			</div>

			<div id="footer" class="row-fluid">
				<?php echo $this->element('footer'); ?>
			</div>
		</div>
	</div>
	<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>