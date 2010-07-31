<div class="proposals form">
<?php echo $this->Form->create('Proposal');?>
	<fieldset>
 		<legend><?php __('Adicionar Proposta de Apresentação'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('event_id', array('empty' => __('-- Selecione o Evento --', true), 'label' => 'Evento'));
		echo $this->Form->input('mini_curriculum', array('label' => __('Seu mini-currículo', TRUE), 'rows' => 7));
		echo $this->Form->input('area', array('label' => __('Palavras-chave', true)));
		echo $this->Form->input('abstract', array('label' => __('O resumo da sua apresentação',TRUE), 'rows' => 7));
		echo $this->Form->input('detailed', array('label' => __('Descrição detalhada (enumere os tópicos)',TRUE), 'rows' => 15));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Proposals', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>