<div class="proposals rating form">
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
</div>
<div class="actions">
	<h3><?php __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Listar Propostas', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Nova Proposta', true), array('action' => 'add')); ?></li>
	</ul>
</div>