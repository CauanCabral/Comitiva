<div class="eventDate">
	<?php
	if(!isset($i))
		$i = 0;

	$this->Form->newLine(array('1', '1', '5'));
	echo $this->Form->input("EventDate.{$i}.date", array(
		'label' => __('Data'),
		'type' => 'text',
		'class' => 'jsDatepicker fullWidth',
		'value' => $this->Form->value("EventDate.{$i}.date") ? $this->Locale->date($this->Form->value("EventDate.{$i}.date")) : ''
		)
	);
	echo $this->Form->input("EventDate.{$i}.time", array(
		'label' => __('Hora'),
		'type' => 'text',
		'class' => 'fullWidth',
		'div' => 'required',
		'value' => $this->Form->value("EventDate.{$i}.time") ?: '00:00'
		)
	);
	echo $this->Form->input("EventDate.{$i}.desc", array(
		'label' => __('Descrição'),
		'class' => 'fullWidth'
		)
	);

	if(isset($id))
		echo $this->Form->input("EventDate.{$i}.id", array('type'=> 'hidden', 'value' => $id));
	?>
</div>