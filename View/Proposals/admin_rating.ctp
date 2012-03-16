<div class="proposals rating form">
	<?php
	$options = array(
		1 => __('Péssimo'),
		2 => __('Ruim'),
		3 => __('Bom'),
		4 => __('Ótimo'),
		5 => __('Excelente')
	);
	
	echo $this->Form->create('Proposal', array('action' => 'rating'));
	echo $this->Form->input('id',array('type' => 'hidden', 'value' => $id));
	echo $this->Form->radio('rating',  $options, array('legend' => __('Avalie a Proposta')));
	
	echo $this->Form->end('Avaliar');
	?>
</div>
<div class="actions">
	<h3><?php echo __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Listar Propostas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Nova Proposta'), array('action' => 'add')); ?></li>
	</ul>
</div>