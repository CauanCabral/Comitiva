<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Modelos'), array('action' => 'index')); ?></li>
	</ul>
	<div class="span9">
		<?php echo $this->Form->create('CertifiedModel', array('class' => 'form-horizontal', 'type' => 'file'));?>
			<fieldset>
				<legend><?php echo __('Novo Modelo de Certificado'); ?></legend>
				<?php
				$this->Form->defineRow(array(8));
				echo $this->Form->input('title', array(
					'required' => 'required',
					'label' => __('Título'),
				));
				$this->Form->defineRow(array(8));
				echo $this->Form->input('description', array(
					'label' => __('Descrição'),
					'type' => 'textarea'
				));
				$this->Form->defineRow(array(8));
				echo $this->Form->input('image', array(
					'required' => 'required',
					'type' => 'file',
					'label' => __('Arquivo da Imagem'),
				));
				?>
			</fieldset>
			<?php echo $this->Form->submit(__('Salvar'));?>
		<?php echo $this->Form->end();?>
	</div>
</div>
