<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Listar Usuários'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo Evento'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Pagamentos'), array('controller' => 'payments', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions form">
<?php echo $this->Form->create('Subscription');?>
	<fieldset>
 		<legend><?php echo __('Nova Inscrição');?></legend>
	<?php
		echo $this->Form->input('user_id', array('label' => __('Usuário', TRUE)));
		echo $this->Form->input('event_id', array('label' => __('Evento', TRUE)));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Adicionar', TRUE));?>
</div>