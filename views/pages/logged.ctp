<h3>O que você quer fazer agora?</h3>
<ul>
	<li><?php echo $this->Html->link(__('Inscrever-se em um evento.', 1), array('controller' => 'events', 'action' => 'index', 'participant' => true)); ?></li>
	<li><?php echo $this->Html->link(__('Informar um pagamento.', 1), array('controller' => 'payments', 'action' => 'index', 'participant' => true)); ?></li>
	<li><?php echo $this->Html->link(__('Atualizar dados cadastrais.', 1), array('controller' => 'users', 'action' => 'profile', 'participant' => true)); ?></li>
	<li><?php echo $this->Html->link(__('Enviar uma proposta de apresentação', 1), array('controller' => 'proposals', 'action' => 'add', 'participant' => true)); ?></li>
</ul>
