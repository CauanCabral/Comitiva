<?php
	echo $this->element('editor');
?>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="events form">
<?php echo $this->Form->create('Event');?>
	<fieldset>
 		<legend><?php echo __('Novo Evento');?></legend>
	<?php
		echo $this->Form->input('Event.id');
    echo $this->Form->input('Event.open_for_proposals', array('type' => 'checkbox', 'label' => __('Aberto para Submissão de Propostas')));
		echo $this->Form->input('Event.title', array('label' => __('Titulo')));
		echo $this->Form->input('Event.description', array('label' => __('Descrição'), 'rows' => 15));
		echo $this->Form->input('Event.parent_id', array('label' => __('Macro Evento'), 'options' => array_merge(array('Selecione um evento'),$events)));
		echo $this->Form->input('Event.free', array('label' => __('Gratuito?')));
		
		/******
		 * EventPrice hasMany add
		 */
		echo $this->Html->link(__('Adicionar preço'), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventPrice'));
		echo $this->Form->input('EventPrice.counter', array('type' => 'hidden', 'value' => 0, 'id' => 'priceCounter'));
		echo '<fieldset id="pricesEvent">';
		
		// Recover error state
		if(isset($this->request->data['EventPrice']) && !empty($this->request->data['EventPrice']))
		{
			$counter = 0;
			
			foreach($this->request->data['EventPrice'] as $i => $eventPrice)
			{
				echo $this->requestAction("/admin/events/eventPriceAdd/index:{$i}/id:{$eventPrice['id']}");
				$counter++;
			}
			
			echo $this->Html->scriptBlock('$("#priceCounter").val('. $counter .')', array('inline' => false));
		}
		
		echo '</fieldset>';
		
		/******
		 * EventDate hasMany add
		 */
		echo $this->Html->link(__('Adicionar data'), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventDate'));
		echo $this->Form->input('EventDate.counter', array('type' => 'hidden', 'value' => 0, 'id' => 'dateCounter'));
		echo '<fieldset id="datesEvent">';
		
		// Recover error state
		if(isset($this->request->data['EventDate']) && !empty($this->request->data['EventDate']))
		{
			$counter = 0;
			
			foreach($this->request->data['EventDate'] as $i => $eventDate)
			{	
				echo $this->requestAction("/admin/events/eventDateAdd/index:{$i}/id:{$eventDate['id']}");
				$counter++;
			}
			
			echo $this->Html->scriptBlock('$("#dateCounter").val('. $counter .')', array('inline' => false));
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
	 		url: '../eventPriceAdd/',
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
	 		url: '../eventDateAdd/',
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
<?php echo $this->Form->end(__('Salvar'));?>
</div>