<?php
	if(!isset($i) || !is_int($i))
	{
		$i = 0;
	}
	echo $this->Form->input("EventDate.{$i}.date", array('label' => __('Data', TRUE), 'class' => "date_{$i}"));
?>