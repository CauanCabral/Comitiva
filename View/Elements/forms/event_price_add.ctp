<?php
if(!isset($i))
{
	$i = 0;
}
echo '<div class="eventPrice">';
	echo $this->Form->input("EventPrice.{$i}.price", array(
		'class' => 'fullWidth',
		'label' => __('Valor')
		)
	);
	echo $this->Form->input("EventPrice.{$i}.start_date", array(
		'label' => __('Data inicial'),
		'type' => 'text',
		'class' => 'jsDatepicker fullWidth'
		)
	);
	echo $this->Form->input("EventPrice.{$i}.final_date", array(
		'label' => __('Data final'),
		'type' => 'text',
		'class' => 'jsDatepicker fullWidth'
		)
	);
	echo $this->Form->input("EventPrice.{$i}.observation", array(
		'label' => __('Observação'),
		'class' => 'fullWidth',
		)
	);

	if(isset($id))
	{
		echo $this->Form->input("EventPrice.{$i}.id", array('type'=> 'hidden', 'value' => $id));
	}

echo '</div>';