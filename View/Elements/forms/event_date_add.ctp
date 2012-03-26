<?php
if(!isset($i))
{
	$i = 0;
}
echo '<div class="eventDate">';
	echo $this->Form->inputBootstrap("EventDate.{$i}.date", array(
		'label' => __('Data'),
		'type' => 'text',
		'class' => 'jsDatepicker',
		'value' => $this->Form->value("EventDate.{$i}.date") ? $this->Locale->date($this->Form->value("EventDate.{$i}.date")) : ''
		)
	);
	echo $this->Form->inputBootstrap("EventDate.{$i}.desc", array(
		'label' => __('Desc')
		)
	);

	if(isset($id))
	{
		echo $this->Form->input("EventDate.{$i}.id", array('type'=> 'hidden', 'value' => $id));
	}
echo '</div>';