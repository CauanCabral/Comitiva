<?php
	if(!isset($i) || !is_int($i))
	{
		$i = 0;
	}
	echo '<div class="eventPrice">';
		echo $this->Form->input("EventPrice.{$i}.price", array(
			'label' => __('Valor', TRUE)
			)
		);
		echo $this->Form->input("EventPrice.{$i}.start_date", array(
			'label' => __('Data inicial', TRUE),
			'minYear' => date('Y'),
			'maxYear' => date('Y') + 5
			)
		);
		echo $this->Form->input("EventPrice.{$i}.final_date", array(
			'label' => __('Data final', TRUE),
			'minYear' => date('Y'),
			'maxYear' => date('Y') + 5
			)
		);
		
	echo '</div>';
?>