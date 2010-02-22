<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Eventos', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Listar Datas de Eventos', true), array('controller' => 'event_dates', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Preços de Eventos', true), array('controller' => 'event_prices', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="events form">
<?php echo $form->create('Event');?>
	<fieldset>
 		<legend><?php __('Novo Evento');?></legend>
	<?php
		echo $form->input('title', __('Titulo',1));
		echo $form->input('description', __('Descrição',1));
		echo $form->input('parent_id',__('Evento Pai', 1));
		echo $form->input('free', __('Gratuito?',1));
	?>
	</fieldset>
<?php echo $form->end('Salvar');?>
</div>