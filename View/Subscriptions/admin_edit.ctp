<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Apagar'), array('action' => 'delete', $this->Form->value('Subscription.id')), null, sprintf(__('Tem certeza que deseja apagar # %s?'), $this->Form->value('Subscription.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Listar Usuários'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo Usuário'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lisar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novos Eventos'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Pagamentos'), array('controller' => 'payments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novos Pagamentos'), array('controller' => 'payments', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="subscriptions form">
<?php echo $this->Form->create('Subscription');?>
	<fieldset>
 		<legend><?php echo __('Editar Inscrição');?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('event_id');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>