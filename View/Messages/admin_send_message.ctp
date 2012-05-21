<?php echo $this->element('editor'); ?>
<div class="row-fluid">
<?php echo $this->Form->create('Message', array('action' => 'sendMessage'));?>
	<fieldset>
 		<legend><?php echo __('Enviar Mensagem');?></legend>
	<?php
		$this->Form->defineRow(array(3, 3, 2));
		echo $this->Form->input('Message.to', array(
			'label' => __('Enviar para'),
			'options' => $types
		));
		echo $this->Form->input('Message.toFilter', array(
			'label' => __('Selecione um filtro'),
			'options' => $filters
		));
		echo $this->Form->input('Message.event_id', array('label' => __('Evento'),'options' => $events));

		$this->Form->defineRow(array(8));
		echo $this->Form->input('Message.subject', array('label' => __('Assunto'), 'class' => 'fullWidth'));

		$this->Form->defineRow(array(10));
		echo $this->Form->input('Message.text', array('label' => __('Mensagem'), 'rows' => 15));
	?>
	</fieldset>
	<?php echo $this->Form->submit(__('Enviar'));?>
</div>