<h2>Recuperação de Senha</h2>
<div class="login">
<?php
	echo $form->create('User', array('url' => array('controller' => 'users', 'action' =>'recover')));
	echo $form->input('User.email');
	echo $form->end('Enviar instruções');
?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link('Entrar', array('action' => 'login', 'admin' => false)); ?></li>
	</ul>
</div>