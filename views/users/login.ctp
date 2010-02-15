<h2>Login</h2>
<div class="login" >
	<?php
	echo $form->create('User',	array('url' => array('controller' => 'users', 'action' =>'login')));
	echo $form->input('User.username', array('label' => __('Usuário', TRUE)));
	echo $form->input('User.password', array('label' => __('Senha', TRUE)));
	echo $form->end(__('Entrar', TRUE));
	?>
	<br />
	<?php echo $this->Html->link(__('Esqueceu sua senha?', TRUE), array('controller' => 'users', 'action' => 'recover')); ?>
	<br />
	<?php echo $this->Html->link(__('Crie uma conta aqui.', TRUE), array('controller' => 'users', 'action' => 'account_create')); ?>
</div>