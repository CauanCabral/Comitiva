<html>
	<head>
		<title><?php echo $title_for_layout;?></title>
	</head>

	<body>
		<?php echo $this->fetch('content');?>

		<p>
			Atenciosamente,
			<br />
			<?php echo Configure::read('Comitiva.fullName'); ?>
		</p>

		<br />--------------------------<br />

		<p>
			Este email foi enviado pelo <a href="http://comitiva.phpms.org">Comitiva</a>, sistema de gerenciamento de eventos do <a href="http://www.phpms.org">PHPMS</a>.
			<br />
			Sistema constru&iacute;do usando <a href="http://cakephp.org">CakePHP Framework</a>
		</p>
	</body>
</html>