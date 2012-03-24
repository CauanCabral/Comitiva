<div class="well">
	<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login'), 'class' => 'login'));?>
	<fieldset>
	<legend><?php echo __('Login'); ?></legend>
	<?php
		$this->Form->newLine(array('3'));
		echo $this->Form->input('User.username', array('label' => __('Usuário')));
		$this->Form->newLine(array('3'));
		echo $this->Form->input('User.password', array('label' => __('Senha')));
		echo $this->Form->submit(__('Entrar'), array('div' => 'loginSubmit'));
	?>
	</fieldset>

<?php echo $this->Html->glyphLink(__('Esqueceu sua senha?'), array('controller' => 'users', 'action' => 'recover'), array('glyph' => 'glyph-key')); ?>
<br />
<?php echo $this->Html->glyphLink(__('Criar uma conta gratuitamente'), array('controller' => 'users', 'action' => 'account_create'), array('glyph' => 'glyph-exclamation-sign')); ?>
</div>