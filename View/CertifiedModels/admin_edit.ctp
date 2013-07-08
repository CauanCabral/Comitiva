<div class="row-fluid">
	<ul  class="nav nav-tabs nav-stacked span2">
			<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CertifiedModel.id')), null, __('Quer mesmo apagar o Certificado \'%s\'?', $this->Form->value('CertifiedModel.title'))); ?></li>
			<li><?php echo $this->Html->link(__('Listar Certificados'), array('action' => 'index'));?></li>
	</ul>
	<div class="span10">
		<fieldset>
			<legend><h2><?php echo __('Editar Modelo de Certificado'); ?></h2></legend>
		<dl>	
			<?php
			$this->Form->defineRow(array(8));
			echo $this->Form->input('CertifiedModel.title', array(
				'required' => 'required',
				'label' => __('Título'),
			));
			$this->Form->defineRow(array(8));
			echo $this->Form->input('CertifiedModel.description', array(
				'label' => __('Descrição'),
				'type' => 'textarea'
			));
			$this->Form->defineRow(array(8));
			echo $this->Form->input('CertifiedModel.image', array(
				'required' => 'required',
				'type' => 'file',
				'label' => __('Arquivo da Imagem'),
			));
			?>
		</dl>
		</fieldset>
		<?php echo $this->Form->submit(__('Salvar'));?>
	</div>
</div>