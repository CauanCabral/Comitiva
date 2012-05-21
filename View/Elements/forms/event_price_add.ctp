<div class="eventPrice">
	<?php
	if(!isset($i))
		$i = 0;

	$this->Form->defineRow(array(1, 1, 1, 4));
	echo $this->Form->input("EventPrice.{$i}.price", array(
		'class' => 'fullWidth',
		'label' => __('Valor'),
		'value' => $this->Form->value("EventPrice.{$i}.price") ? $this->Locale->number($this->Form->value("EventPrice.{$i}.price")) : ''
		)
	);
	echo $this->Form->input("EventPrice.{$i}.start_date", array(
		'label' => __('Data inicial'),
		'type' => 'text',
		'class' => 'jsDatepicker fullWidth',
		'value' => $this->Form->value("EventPrice.{$i}.start_date") ? $this->Locale->date($this->Form->value("EventPrice.{$i}.start_date")) : ''
		)
	);
	echo $this->Form->input("EventPrice.{$i}.final_date", array(
		'label' => __('Data final'),
		'type' => 'text',
		'class' => 'jsDatepicker fullWidth',
		'value' => $this->Form->value("EventPrice.{$i}.final_date") ? $this->Locale->date($this->Form->value("EventPrice.{$i}.final_date")) : ''
		)
	);
	echo $this->Form->input("EventPrice.{$i}.observation", array(
		'label' => __('Observação'),
		'class' => 'fullWidth',
		)
	);

	if(isset($id))
		echo $this->Form->input("EventPrice.{$i}.id", array('type'=> 'hidden', 'value' => $id));
?>
</div>