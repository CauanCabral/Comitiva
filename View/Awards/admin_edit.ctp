<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Excluir'), array('action' => 'delete', $this->Form->value('Award.id')), null, __('Deseja excluir o sorteio?')); ?></li>
		<li><?php echo $this->Html->link(__('Listar todos'), array('action' => 'index'));?></li>
	</ul>
	<div class="span10">
		<?php echo $this->BootstrapForm->create('Award');?>
			<fieldset>
				<legend><?php echo __('Alterar Sorteio'); ?></legend>
				<?php
				echo $this->BootstrapForm->input('title', array(
					'required' => 'required',
					'label' => __('Título')
				));
				echo $this->BootstrapForm->input('description', array(
					'label' => __('Descrição')
				));
				echo $this->BootstrapForm->hidden('id');
				?>
				<?php echo $this->BootstrapForm->submit(__('Salvar'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
</div>