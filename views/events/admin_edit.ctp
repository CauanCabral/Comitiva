<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Apagar', true), array('action' => 'delete', $form->value('Event.id')), null, sprintf(__('Tem certeza que deseja apagar # %s?', true), $form->value('Event.id'))); ?></li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Listar Datas de Eventos', true), array('controller' => 'event_dates', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Preços de Eventos', true), array('controller' => 'event_prices', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Inscriçao', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="events form">
<?php echo $form->create('Event');?>
	<fieldset>
 		<legend><?php __('Editar Evento');?></legend>
	<?php
		echo $form->input('title',__('Titulo'));
		echo $form->input('description',__('Descrição'));
		echo $form->input('parent_id',__('Evento Pai'));
		echo $form->input('free', __('Gratuito?'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
