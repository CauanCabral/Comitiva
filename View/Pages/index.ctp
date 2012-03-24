<div class="span10">
	<p>
	Bem vindo(a),<br /><br />
	No Comitiva você acompanha eventos disponíveis, mantém histórico dos eventos<br />
	que participou, entra em contato com os organizadores, avalia eventos e pode ganhar<br />
	descontos nas inscrições.<br />
	<br />
	Se você ainda não possui uma conta, se cadastre agora, é rápido e grátis.
	</p>
	<p>
	<?php
	if(!isset($activeUser)):
		echo $this->Html->link(__('Já sou cadastrado'), array('admin' => false, 'participant' => false, 'controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-primary vspace')),
			'<br />',
			$this->Html->link(__('Quero me cadastrar'), array('admin' => false, 'participant' => false, 'controller' => 'users', 'action' => 'account_create'), array('class' => 'btn vspace'));
	endif;
	?>
	</p>
</div>