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
    echo $this->Form->input('Event.open_for_proposals', array('type' => 'checkbox', 'label' => __('Aberto para Submissão de Propostas', true)));
		echo $this->Form->input('Event.title', array('label' => __('Titulo',TRUE)));
		echo $this->Form->input('Event.description', array('label' => __('Descrição',TRUE), 'rows' => 15));
		echo $this->Form->input('Event.parent_id', array('label' => __('Macro Evento', TRUE), 'options' => array_merge(array('Selecione um evento'),$events)));
		echo $this->Form->input('Event.free', array('label' => __('Gratuito?',TRUE)));
		
		/******
		 * EventPrice hasMany add
		 */
		echo $this->Html->link(__('Adicionar preço', TRUE), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventPrice'));
		echo $this->Form->input('EventPrice.counter', array('type' => 'hidden', 'value' => 0, 'id' => 'priceCounter'));
		echo '<fieldset id="pricesEvent"></fieldset>';
		
		// Recover error state
		if(isset($this->data['EventPrice']) && !empty($this->data['EventPrice']))
		{
			$counter = 0;
			
			foreach($this->data['EventPrice'] as $i => $eventPrice)
			{
				echo $this->requestAction("/admin/events/eventPriceAdd/index:{$i}");
				$counter++;
			}
			
			$this->Html->scriptBlock('$("#priceCounter").val('. $counter .')');
		}
		
		/******
		 * EventDate hasMany add
		 */
		echo $this->Html->link(__('Adicionar data', TRUE), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventDate'));
		echo $this->Form->input('EventDate.counter', array('type' => 'hidden', 'value' => 0, 'id' => 'dateCounter'));
		echo '<fieldset id="datesEvent"></fieldset>';
		
		// Recover error state
		if(isset($this->data['EventDate']) && !empty($this->data['EventDate']))
		{
			$counter = 0;
			
			foreach($this->data['EventDate'] as $i => $eventDate)
			{
				echo $this->requestAction("/admin/events/eventDateAdd/index:{$i}");
				$counter++;
			}
			
			$this->Html->scriptBlock('$("#dateCounter").val('. $counter .')');
		}
		
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
	 		url: 'eventPriceAdd/',
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
	 		url: 'eventDateAdd/',
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