<?php
	echo $this->element('editor'); 
?>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Tipos de mensagens', true), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="messages form">
<?php echo $this->Form->create('Message', array('action' => 'sendInvitation'));?>
	<fieldset>
 		<legend><?php __('Convidar usuários');?></legend>
	<?php
		echo $this->Form->input('Message.event_id', array('label' => __('Evento', TRUE),'options' => $events));
		echo $this->Form->input('Message.subject', array('label' => __('Assunto',TRUE)));
		echo $this->Form->input('Message.text', array('label' => __('Mensagem',TRUE), 'rows' => 15));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar', TRUE));?>
</div>