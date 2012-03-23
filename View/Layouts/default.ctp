<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo __('Comitiva'), ': ', $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		// Carrega o Google API Loader
		echo $this->Html->script('https://www.google.com/jsapi');
		// Carrega os scripts disponíveis via Google CDN
		echo $this->element('google_loader');

		//========================= Scripts

		// TWITTER
		echo $this->Html->script('bootstrap.min');
		// DATEPICKER
		echo $this->Html->script('bootstrap-datepicker');

		echo $this->Html->script('menu');

		//========================= Estilos

		// JQUERY
		echo $this->Html->css('jquery/ui');
		// TWITTER
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-responsive.min');
		// DATEPICKER
		echo $this->Html->css('datepicker');

		//echo $this->Html->css('comitiva');
		echo $this->Html->css('menu');

		// ======================== Meta, Css e Scripts via Cake
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid" id="content">
			<div id="header">
				<h1><?php echo $this->Html->link(__('Comitiva: Sistema de controle de eventos do PHPMS'), 'http://phpms.org'); ?></h1>
			</div>

			<?php if(isset($menuItems) && !empty($menuItems)): ?>
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
						<?php echo $this->element('menu', $menuItems); ?>
						</ul>
					</div>
				</div>
			</div>
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

				echo $content_for_layout;
				?>
			</div>
			<div id="footer">
				<?php echo $this->element('footer'); ?>
			</div>
		</div>
	</div>
	<?php
		echo $this->Js->writeBuffer();
	?>
</body>
</html>