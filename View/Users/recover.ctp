<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link('Entrar', array('action' => 'login', 'admin' => false)); ?></li>
	</ul>

	<div class="span10">
	<h2>Recuperação de Senha</h2>
	<?php
		echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' =>'recover')));

		$this->Form->defineRow(array(7));
		echo $this->Form->input('User.email', array('class' => 'fullWidth'));
		$this->Form->defineRow(array(3));
		echo $this->Form->submit(__('Enviar instruções'), array('div' => 'loginSubmit'));
	?>
</div>