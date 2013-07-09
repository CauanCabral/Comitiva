<div class="row-fluid">
	<ul  class="nav nav-tabs nav-stacked span2">
			<li><?php echo $this->Html->link(__('Editar Certificado'), array('action' => 'edit', $certifiedModel['CertifiedModel']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Excluir Certificado'), array('action' => 'delete', $certifiedModel['CertifiedModel']['id']), null, __('Quer mesmo apagar o Certificado \'%s\'?', $certifiedModel['CertifiedModel']['title'])); ?> </li>
			<li><?php echo $this->Html->link(__('Listar Certificados'), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('Novo Certificado'), array('action' => 'add')); ?> </li>
	</ul>
	<div class="span10">
		<legend><h2><?php  echo __('Modelo de Certificado');?></h2></legend>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Descrição'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Imagem'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['image']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modified'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
</div>