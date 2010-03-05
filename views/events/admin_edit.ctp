<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Apagar', true), array('action' => 'delete', $form->value('Event.id')), null, sprintf(__('Tem certeza que deseja apagar # %s?', true), $form->value('Event.id'))); ?></li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Novo Evento', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
<div class="events form">
<?php echo $form->create('Event');?>
	<fieldset>
 		<legend><?php __('Editar Evento');?></legend>
	<?php
		echo $form->input('title', array('label' => __('Titulo', TRUE)));
		echo $form->input('description', array('label' => __('Descrição', TRUE)));
		echo $form->input('parent_id', array('label' => __('Evento Pai', TRUE)));
		echo $form->input('free', array('label' => __('Gratuito?', TRUE)));
	?>
	</fieldset>
<?php echo $form->end(__('Submit', TRUE));?>
</div>
