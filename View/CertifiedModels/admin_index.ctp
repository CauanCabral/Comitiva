<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Novo Modelo'), array('action' => 'add')); ?></li>
	</ul>

	<div class="events index span10">
		<h2><?php echo __('Modelos de Certificado');?></h2>
		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<th><?php echo $this->Paginator->sort('CertifiedModel.title', __('Título'));?></th>
				<th><?php echo $this->Paginator->sort('CertifiedModel.description', __('Descrição'));?></th>
				<th><?php echo $this->Paginator->sort('CertifiedModel.image', __('Imagem'));?></th>
				<th class="actions"><?php echo __('Ações');?></th>
			</tr>
			<?php
				foreach ($certifiedModels as $model):
			?>
			<tr>
				<td><?php echo $model['CertifiedModel']['title']?></td>
				<td><?php echo $model['CertifiedModel']['description']?></td>
				<td><?php echo $model['CertifiedModel']['image']?></td>
				<td>
					<?php
					echo $this->Form->postLink(__('Remover'), array('action' => 'delete', $model['CertifiedModel']['id']), null, __('Você quer mesmo apagar o modelo \'%s\'?', $model['CertifiedModel']['title']));
					?>
				</td>
			</tr>
			<?php
				endforeach;
			?>
		</table>
	</div>
</div>
