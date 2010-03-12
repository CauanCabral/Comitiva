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
		echo $this->Form->input('Event.parent_id', array('label' => __('Macro Evento', TRUE), 'options' => array_merge(array('Selecione um evento'),$events)));
		echo $this->Form->input('Event.free', array('label' => __('Gratuito?',TRUE)));
		echo '<div id="eventDates"></div>';
		/**
		 * Js Helper mode
		 *
		echo $this->Js->link(
			__('Adicionar data ao evento', TRUE),
			array('controller' => 'events', 'action' => 'event_date_add', 'prefix' => 'admin'),
			array(
				'wrapCallbacks' => false,
				'success' => 'function(data, textStatus) {$("#eventDates").append(data);}',
				'data' => array('lastDateDiv' => '$("#eventDates:last-child").html()'),
				'evalStripts' => true
			)
		);
		*/
		echo $this->Html->link(__('Adicionar data ao evento', TRUE), array('controller' => 'events', 'action' => 'event_date_add', 'prefix' => 'admin'), array('id' => 'ajaxAddEventDate'));
		/**
		 * JQuery Pure mode
		 */
$ajaxRequest = <<<SCRIPT
$('#ajaxAddEventDate').bind('click', function(event) {
	lastDateLabel = new String($("#eventDates > div:last-child label").attr('for'));
	lastIndex = lastDateLabel.match("[0-9]+");
	
	$.ajax({
		url: "/admin/events/event_date_add",
		data: 'lastDateIndex=' + lastIndex,
		success: function(data, textStatus) { $('#eventDates').append(data); }
	});
	return false;
});
SCRIPT;
		
		echo $this->Html->scriptBlock($ajaxRequest);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar', TRUE));?>
</div>