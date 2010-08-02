<div class="proposals form">
<?php echo $this->Form->create('Proposal');?>
	<fieldset>
 		<legend><?php __('Editar Proposta'); ?></legend>
	<?php
		echo $this->Form->input('event_id', array('label' => __('Evento Alvo',1)));
		echo $this->Form->input('mini_curriculum',array('label' => __('Mini Currículo',1)));
		echo $this->Form->input('area',array('label' => __('Área',1)));
		echo $this->Form->input('abstract',array('label' => __('Resumo',1)));
		echo $this->Form->input('detailed',array('label' => __('Detalhes',1)));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submeter', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Apagar esta Proposta', true), array('action' => 'delete', $this->Form->value('Proposal.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Proposal.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Ver Minhas Propostas', true), array('action' => 'index'));?></li>
	</ul>
</div>