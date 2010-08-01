<?php
	echo $this->element('editor'); 
?>
<div class="proposals form">
<?php echo $this->Form->create('Proposal');?>
	<fieldset>
 		<legend><?php __('Adicionar Proposta'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('event_id');
		echo $this->Form->input('mini_curriculum', array('rows' => 8));
		echo $this->Form->input('area');
		echo $this->Form->input('abstract', array('rows' => 15));
		echo $this->Form->input('detailed', array('rows' => 15));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar', true));?>
</div>
<div class="actions">
	<h3><?php __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Listar Propostas', true), array('action' => 'index'));?></li>
	</ul>
</div>