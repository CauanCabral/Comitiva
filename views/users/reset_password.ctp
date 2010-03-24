<div class="actions">
	<ul>
		<li><?php echo $html->link('Criar nova conta', array('action' => 'add', 'admin' => false)); ?></li>
		<li><?php echo $html->link('Entrar', array('action' => 'login', 'admin' => false)); ?></li>
	</ul>
</div>

<h2><?php __('Recuperação de Senha'); ?></h2>
<div class="form login">
<?php
	echo $this->Form->create('User', array('action' => "/reset_password/{$secureHash}"));
	echo $this->Form->input('User.id', array('type' => 'hidden', 'value' => $user_id));
	echo $this->Form->input('User.new_pass', array('label' => __('Nova senha', TRUE), 'type' => 'password'));
	echo $this->Form->end(__('Salvar', TRUE));
?>
</div>