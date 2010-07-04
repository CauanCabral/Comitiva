<div class="actions">
	<ul>
		<li><?php echo $html->link('Entrar', array('action' => 'login', 'admin' => false)); ?></li>
	</ul>
</div>

<div class="form login">
<h2>Recuperação de Senha</h2>
<?php
	echo $form->create('User', array('url' => array('controller' => 'users', 'action' =>'recover')));
	echo $form->input('User.email');
	echo $form->end('Enviar instruções');
?>
</div>