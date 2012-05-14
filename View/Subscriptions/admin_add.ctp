<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Listar Usuários'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo Evento'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Pagamentos'), array('controller' => 'payments', 'action' => 'index')); ?> </li>
	</ul>

	<div class="span10">
		<?php echo $this->Form->create('Subscription');?>
		<fieldset>
	 		<legend><?php echo __('Nova Inscrição');?></legend>
		<?php
			echo $this->Form->input('event_id', array('label' => __('Evento'), 'id' => 'jsEventId'));
			echo $this->Form->input('user_id', array('type' => 'hidden', 'id' => 'jsUserId'));
			echo $this->Form->input('user_name', array('label' => __('Usuário'), 'type' => 'text', 'id' => 'jsUserName'));
		?>
		</fieldset>
		<?php echo $this->Form->end(__('Adicionar'));?>
	</div>
</div>
<?php echo $this->Html->script('subscriptions'); ?>