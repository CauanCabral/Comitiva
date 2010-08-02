<?php

$options = array(
	1 => __('Péssimo',1),
	2 => __('Ruim',1),
	3 => __('Bom',1),
	4 => __('Ótimo',1),
	5 => __('Excelente', 1)
);

echo $form->create('Proposal', array('action' => 'rating'));
echo $this->Form->input('id',array('type' => 'hidden', 'value' => $id));
echo $this->Form->radio('rating',  $options, array('legend' => __('Avalie a Proposta',1)));

echo $this->Form->end('Avaliar');


?>