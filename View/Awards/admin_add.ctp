<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('Award');?>
			<fieldset>
				<legend><?php echo __('Novo Sorteio'); ?></legend>
				<?php
				echo $this->BootstrapForm->input('title', array(
					'required' => 'required',
					'between' => '<span class="label label-important">' . __('Require') . '</span>&nbsp;',
					'label' => __('Título')
				));
				echo $this->BootstrapForm->input('description', array(
					'label' => __('Descrição')
				));
				?>
				<?php echo $this->BootstrapForm->submit(__('Salvar'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Ações'); ?></li>
			<li><?php echo $this->Html->link(__('Listar Sorteios'), array('action' => 'index'));?></li>
		</ul>
	</div>
</div>
