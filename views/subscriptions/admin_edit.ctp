<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Apagar', true), array('action' => 'delete', $form->value('Subscription.id')), null, sprintf(__('Tem certeza que deseja apagar # %s?', true), $form->value('Subscription.id'))); ?></li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Listar Usuários', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Usuário', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Lisar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novos Eventos', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Listar Pagamentos', true), array('controller' => 'payments', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novos Pagamentos', true), array('controller' => 'payments', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="subscriptions form">
<?php echo $form->create('Subscription');?>
	<fieldset>
 		<legend><?php __('Editar Inscrição');?></legend>
	<?php
		echo $form->input('user_id');
		echo $form->input('event_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>