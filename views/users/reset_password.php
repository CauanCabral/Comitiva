<h2>Recuperação de Senha</h2>
<div class="login">
<?php
	echo $form->create('User', array('url' => array('controller' => 'users', 'action' =>'reset_password')));
	echo $form->input('User.new_pass', array('type' => 'password'));
	echo $form->end('Salvar');
?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link('Criar nova conta', array('action' => 'add', 'admin' => false)); ?></li>
		<li><?php echo $html->link('Entrar', array('action' => 'login', 'admin' => false)); ?></li>
	</ul>
</div>