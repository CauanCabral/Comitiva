<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Eventos', true), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="events form">
<?php echo $this->Form->create('Event');?>
	<fieldset>
 		<legend><?php __('Novo Evento');?></legend>
	<?php
		echo $this->Form->input('Event.title', array('label' => __('Titulo',TRUE)));
		echo $this->Form->input('Event.description', array('label' => __('Descrição',TRUE)));
		echo $this->Form->input('Event.parent_id', array('label' => __('Macro Evento', TRUE), 'options' => $events));
		echo $this->Form->input('Event.free', array('label' => __('Gratuito?',TRUE)));
		echo '<div id="eventDates"></div>';
		echo $this->Js->link(
			__('Adicionar data ao evento', TRUE),
			array('controller' => 'events', 'action' => 'event_date_add', 'prefix' => 'admin'),
			array('wrapCallbacks' => false, 'success' => 'function(data, textStatus) {$("#eventDates").append(data);}')
		);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar', TRUE));?>
</div>