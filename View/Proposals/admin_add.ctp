<?php echo $this->element('editor'); ?>
<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Propostas'), array('action' => 'index'));?></li>
	</ul>
	<div class="span10">
	<?php echo $this->Form->create('Proposal');?>
		<fieldset>
	 		<legend><?php echo __('Adicionar Proposta'); ?></legend>
		<?php
			$this->Form->defineRow(array(3, 3));
			echo $this->Form->input('user_id', array(
				'label' => __('Palestrante'),
				'class' => 'fullWidth',
				'required'=>false
				)
			);
			echo $this->Form->input('event_id', array(
				'label' => __('Evento Alvo'),
				'class' => 'fullWidth'
				)
			);
			$this->Form->defineRow(array(4));
			echo $this->Form->input('area', array(
				'label' => __('Área'),
				'class' => 'fullWidth',
				)
			);
			$this->Form->defineRow(array(8));
			echo $this->Form->input('mini_curriculum', array(
				'label' => __('Mini Currículo'),
				'rows' => 8,
				'class' => 'fullWidth'
				)
			);
			$this->Form->defineRow(array(8));
			echo $this->Form->input('abstract', array(
				'label' => __('Resumo'),
				'rows' => 8,
				'class' => 'fullWidth'
				)
			);
			$this->Form->defineRow(array(8));
			echo $this->Form->input('detailed', array(
				'label' => __('Detalhes'),
				'rows' => 15,
				'class' => 'fullWidth'
				)
			);
		?>
		</fieldset>
	<?php echo $this->Form->end(__('Enviar'));?>
	</div>
</div>