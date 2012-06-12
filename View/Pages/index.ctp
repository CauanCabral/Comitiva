<div class="span12 hero-unit">
	<p>
	<h1>Bem vindo!</h1><br />
	<h3>No Comitiva você acompanha eventos disponíveis, mantém histórico dos eventos<br />
	que participou, entra em contato com os organizadores, avalia eventos e pode ganhar<br />
	descontos nas inscrições.<br />
	</h3><br />
	<h3>Se você ainda não possui uma conta, se cadastre agora, é rápido e grátis.</h3>
	</p>
	<p>
	<?php
	if(!isset($activeUser)):
		echo $this->Html->link(__('Já sou cadastrado'), array('admin' => false, 'participant' => false, 'controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-primary btn-large vspace')) , "&nbsp", "&nbsp",
			$this->Html->link(__('Quero me cadastrar'), array('admin' => false, 'participant' => false, 'controller' => 'users', 'action' => 'account_create'), array('class' => 'btn btn-large btn-primary vspace'));
	endif;
	?>
	</p>
</div>