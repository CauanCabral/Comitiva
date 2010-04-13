<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Listar Usuários', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Evento', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Listar Pagamentos', true), array('controller' => 'payments', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions form">
<?php echo $form->create('Subscription');?>
	<fieldset>
 		<legend><?php __('Nova Inscrição');?></legend>
	<?php
		echo $this->Form->input('user_id', array('label' => __('Usuário', TRUE)));
		echo $this->Form->input('event_id', array('label' => __('Evento', TRUE)));
	?>
	</fieldset>
<?php echo $form->end(__('Adicionar', TRUE));?>
</div>