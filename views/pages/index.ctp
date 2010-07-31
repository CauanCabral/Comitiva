<p>
Bem vindo(a),<br /><br />
No Comitiva você acompanha eventos disponíveis, mantém histórico dos eventos<br />
que participou, entra em contato com os organizadores, avalia eventos e pode ganhar<br />
descontos nas inscrições.<br />
<br />
Se você ainda não possui uma conta, se cadastre agora, é rápido e grátis.</p>

<br />

<?php
if(!isset($activeUser)):
?>
<ul>
	<li class="button"><?php echo $this->Html->link(__('Já sou cadastrado', true), array('admin' => false, 'participant' => false, 'controller' => 'users', 'action' => 'login'));?></li>
	<li class="button"><?php echo $this->Html->link(__('Quero me cadastrar', true), array('admin' => false, 'participant' => false, 'controller' => 'users', 'action' => 'account_create'));?>
</ul>
<?php
endif;
?>
