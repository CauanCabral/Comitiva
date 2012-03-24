<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('Award');?>
			<fieldset>
				<legend><?php echo __('Alterar Sorteio'); ?></legend>
				<?php
				echo $this->BootstrapForm->input('title', array(
					'required' => 'required',
					'between' => '<span class="label label-important">' . __('Obrigatório') . '</span>&nbsp;'),
					'label' => __('Título')
				);
				echo $this->BootstrapForm->input('description', array(
					'label' => __('Descrição')
				));
				echo $this->BootstrapForm->hidden('id');
				?>
				<?php echo $this->BootstrapForm->submit(__('Salvar'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Ações'); ?></li>
			<li><?php echo $this->Form->postLink(__('Excluir'), array('action' => 'delete', $this->Form->value('Award.id')), null, __('Deseja excluir o sorteio?')); ?></li>
			<li><?php echo $this->Html->link(__('Listar todos'), array('action' => 'index'));?></li>
		</ul>
	</div>
</div>