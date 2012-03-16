<div class="proposals form">
<?php echo $this->Form->create('Proposal');?>
	<fieldset>
 		<legend><?php echo __('Editar Proposta'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('event_id', array('label' => __('Evento Alvo')));
		echo $this->Form->input('mini_curriculum',array('label' => __('Mini Currículo'), 'rows' => 8));
		echo $this->Form->input('area',array('label' => __('Área')));
		echo $this->Form->input('abstract',array('label' => __('Resumo'), 'rows' => 8));
		echo $this->Form->input('detailed',array('label' => __('Detalhes'), 'rows' => 15));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar'));?>
</div>
<div class="actions">
	<h3><?php echo __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Apagar esta Proposta'), array('action' => 'delete', $this->Form->value('Proposal.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Proposal.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Ver Minhas Propostas'), array('action' => 'index'));?></li>
	</ul>
</div>