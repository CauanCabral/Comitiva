<?php
	echo $this->element('editor');
?>
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
		echo $this->Form->input('Event.description', array('label' => __('Descrição',TRUE), 'rows' => 15));
		echo $this->Form->input('Event.parent_id', array('label' => __('Macro Evento', TRUE), 'options' => array_merge(array('Selecione um evento'),$events)));
		echo $this->Form->input('Event.free', array('label' => __('Gratuito?',TRUE)));
		
		/******
		 * EventPrice hasMany add
		 */
		echo $this->Html->link(__('Adicionar preço', TRUE), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventPrice'));
		echo $this->Form->input('EventPrice.counter', array('type' => 'hidden', 'value' => 0, 'id' => 'priceCounter'));
		echo '<fieldset id="pricesEvent">';
		
		// Recover error state
		if(isset($this->data['EventPrice']) && !empty($this->data['EventPrice']))
		{
			$counter = 0;
			
			foreach($this->data['EventPrice'] as $i => $eventPrice)
			{
				// if this is a saved price
				if(isset($eventPrice['id']))
				{
					// display field to save id value
					echo $this->Form->input("EventPrice.{$i}.id", array('type'=> 'hidden', 'value' => $eventPrice['id']));
				}
				
				echo $this->requestAction("/admin/events/event_price_add/id:{$i}");
				$counter++;
			}
			
			$this->Html->scriptBlock('$("#priceCounter").val('. $counter .')');
		}
		
		echo '</fieldset>';
		
		/******
		 * EventDate hasMany add
		 */
		echo $this->Html->link(__('Adicionar data', TRUE), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventDate'));
		echo $this->Form->input('EventDate.counter', array('type' => 'hidden', 'value' => 0, 'id' => 'dateCounter'));
		echo '<fieldset id="datesEvent">';
		
		// Recover error state
		if(isset($this->data['EventDate']) && !empty($this->data['EventDate']))
		{
			$counter = 0;
			
			foreach($this->data['EventDate'] as $i => $eventDate)
			{
				// if this is a saved date
				if(isset($eventDate['id']))
				{
					// display field to save id value
					echo $this->Form->input("EventDate.{$i}.id", array('type'=> 'hidden', 'value' => $eventDate['id']));
				}
				
				echo $this->requestAction("/admin/events/event_date_add/id:{$i}");
				$counter++;
			}
			
			$this->Html->scriptBlock('$("#dateCounter").val('. $counter .')');
		}
		
		echo '</fieldset>';
		
$handlers = <<<SCRIPT
	$('#EventFree').bind('click', function (e) {
		
		// se ele foi selecionado, então reseta campos de preço
		if($(this).attr('checked') == true)
		{
			$('#priceCounter').val(0);
			$('#pricesEvent').html('');
		}
	});
	
	$('#addEventPrice').bind('click', function (e) {
		e.preventDefault();
	
	 	counter = parseInt($('#priceCounter').val());
	 	
	 	$.ajax({
	 		url: '/admin/events/event_price_add/',
	 		data: 'lastPriceIndex=' + counter,
	 		success: function(data, eventStatus) {
	 			$('#EventFree').attr('checked', false);
	 			$('#pricesEvent').append(data);
	 			$('#priceCounter').val(counter + 1);
	 		}
	 	});
	 
	 	return false;
	 });
	 
	 $('#addEventDate').bind('click', function (e) {
	 	e.preventDefault();
	 	
	 	counter = parseInt($('#dateCounter').val());
	 	
	 	$.ajax({
	 		url: '/admin/events/event_date_add/',
	 		data: 'lastDateIndex=' + counter,
	 		success: function(data, eventStatus) {
	 			$('#datesEvent').append(data);
	 			$('#dateCounter').val(counter + 1);
	 		}
	 	});
	 
	 	return false;
	 });
SCRIPT;

		echo $this->Html->scriptBlock($handlers, array('secure' => true));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar', TRUE));?>
</div>