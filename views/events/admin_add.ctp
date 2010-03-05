<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Eventos', true), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="events form">
<?php echo $form->create('Event');?>
	<fieldset>
 		<legend><?php __('Novo Evento');?></legend>
	<?php
		echo $form->input('Event.title', array('label' => __('Titulo',TRUE)));
		echo $form->input('Event.description', array('label' => __('Descrição',TRUE)));
		echo $form->input('Event.parent_id', array('label' => __('Macro Evento', TRUE), 'options' => $events));
		echo $form->input('Event.free', array('label' => __('Gratuito?',TRUE)));
	?>
	</fieldset>
<?php echo $form->end(__('Salvar', TRUE));?>
</div>