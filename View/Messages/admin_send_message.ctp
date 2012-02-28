<?php
	echo $this->element('editor'); 
?>
<div class="messages form">
<?php echo $this->Form->create('Message', array('action' => 'sendMessage'));?>
	<fieldset>
 		<legend><?php echo __('Enviar Mensagem');?></legend>
	<?php
		echo $this->Form->input('Message.to', array(
			'legend' => __('Enviar para', TRUE),
			'type' => 'radio',
			'options' => $types
		));
		echo $this->Form->input('Message.toFilter', array(
			'legend' => __('Selecione os filtros para seleção dos destinatários', TRUE),
			'type' => 'radio',
			'options' => $filters
		));
		echo $this->Form->input('Message.event_id', array('label' => __('Evento', TRUE),'options' => $events));
		echo $this->Form->input('Message.subject', array('label' => __('Assunto',TRUE)));
		echo $this->Form->input('Message.text', array('label' => __('Mensagem',TRUE), 'rows' => 15));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar', TRUE));?>
</div>