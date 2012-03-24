<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Premiações'), array('action' => 'index'));?></li>
	</ul>
	<div class="span10">
		<?php echo $this->BootstrapForm->create('Award');?>
			<fieldset>
				<legend><?php echo __('Novo Sorteio'); ?></legend>
				<?php
				echo $this->BootstrapForm->input('title', array(
					'required' => 'required',
					'label' => __('Título'),
					'class' => 'fullWidth'
				));
				echo $this->BootstrapForm->input('description', array(
					'label' => __('Descrição'),
					'class' => 'fullWidth'
				));
				?>
				<?php echo $this->BootstrapForm->submit(__('Salvar'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
</div>
