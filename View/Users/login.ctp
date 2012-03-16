<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login'), 'class' => 'login'));?>
<fieldset>
	<legend><?php echo __('Login'); ?></legend>
	<?php
	echo $this->Form->input('User.username', array('label' => __('Usuário')));
	echo $this->Form->input('User.password', array('label' => __('Senha')));
	echo $this->Form->submit(__('Entrar'));
	?>
</fieldset>

<?php echo $this->Html->link(__('Esqueceu sua senha?'), array('controller' => 'users', 'action' => 'recover')); ?>
<br />
<?php echo $this->Html->link(__('Criar uma conta gratuitamente'), array('controller' => 'users', 'action' => 'account_create')); ?>
<?php echo $this->Form->end();?>