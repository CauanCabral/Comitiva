<div class="actions">
	<ul>
		<li><?php echo $this->Html->link('Entrar', array('action' => 'login', 'admin' => false)); ?></li>
	</ul>
</div>

<div class="form login">
<h2>Recuperação de Senha</h2>
<?php
	echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' =>'recover')));
	echo $this->Form->input('User.email');
	echo $this->Form->end('Enviar instruções');
?>
</div>