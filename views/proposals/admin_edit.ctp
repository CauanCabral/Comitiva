<div class="proposals form">
<?php echo $this->Form->create('Proposal');?>
	<fieldset>
 		<legend><?php __('Admin Edit Proposal'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('event_id');
		echo $this->Form->input('mini_curriculum');
		echo $this->Form->input('area');
		echo $this->Form->input('abstract');
		echo $this->Form->input('detailed');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar', true));?>
</div>
<div class="actions">
	<h3><?php __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Remover', true), array('action' => 'delete', $this->Form->value('Proposal.id')), null, sprintf(__('	Você realmente deseja excluir  # %s?', true), $this->Form->value('Proposal.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Propostas', true), array('action' => 'index'));?></li>
	</ul>
</div>