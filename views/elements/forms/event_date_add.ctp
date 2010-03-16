<?php
	if(!isset($i))
	{
		$i = 0;
	}
	echo '<div class="eventDate">';
		echo $this->Form->input("EventDate.{$i}.date", array(
			'label' => __('Data', TRUE),
			'type' => 'datetime',
			'minYear' => date('Y'),
			'maxYear' => date('Y') + 5
			)
		);
		echo $this->Form->input("EventDate.{$i}.desc", array(
			'label' => __('Desc', TRUE)
			)
		);
	echo '</div>';
?>