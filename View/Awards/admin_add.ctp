<?php echo $this->element('editor'); ?>
<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Premiações'), array('action' => 'index'));?></li>
	</ul>
	<div class="span10">
		<?php echo $this->Form->create('Award');?>
			<fieldset>
				<legend><?php echo __('Novo Sorteio'); ?></legend>
				<?php
				$this->Form->newLine(array('5'));
				echo $this->Form->input('title', array(
					'required' => 'required',
					'label' => __('Título'),
					'class' => 'fullWidth'
				));
				$this->Form->newLine(array('7'));
				echo $this->Form->input('description', array(
					'label' => __('Descrição'),
					'rows' => 15
				));
				?>
			</fieldset>
			<?php echo $this->Form->submit(__('Salvar'));?>
	</div>
</div>
