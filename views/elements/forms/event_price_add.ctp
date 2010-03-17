<?php
	if(!isset($i))
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
		
		// case form is showed in edit action
		if(isset($id))
		{
			echo $this->Form->input("EventPrice.{$i}.id", array('type'=> 'hidden', 'value' => $id));
		}
		
	echo '</div>';
?>