<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link('Criar nova conta', array('action' => 'add', 'admin' => false)); ?></li>
		<li><?php echo $this->Html->link('Entrar', array('action' => 'login', 'admin' => false)); ?></li>
	</ul>

	<div class="span10">
	<h2><?php echo __('Recuperação de Senha'); ?></h2>
	<?php
		echo $this->Form->create('User', array('action' => "/reset_password/{$secureHash}"));
		echo $this->Form->input('User.id', array('type' => 'hidden', 'value' => $user_id));
		$this->Form->newLine(array('4'));
		echo $this->Form->input('User.password', array('label' => __('Nova senha'), 'type' => 'password', 'class' => 'fullWidth'));
		$this->Form->newLine(array('4'));
		echo $this->Form->end(__('Salvar'));
	?>
	</div>
</div>