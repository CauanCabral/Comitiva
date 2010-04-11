<?php
	echo $this->element('editor'); 
?>
<div class="messages form">
<?php echo $this->Form->create('Message', array('action' => 'sendMessage'));?>
	<fieldset>
 		<legend><?php __('Enviar Mensagem');?></legend>
	<?php
		echo $this->Form->input('Message.type', array('label' => __('Tipo de Mensagem', TRUE), 'options' => $types));
		echo $this->Form->input('Message.event_id', array('label' => __('Evento', TRUE),'options' => $events));
		echo $this->Form->input('Message.subject', array('label' => __('Assunto',TRUE)));
		echo $this->Form->input('Message.text', array('label' => __('Mensagem',TRUE), 'rows' => 15));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar', TRUE));?>
</div>