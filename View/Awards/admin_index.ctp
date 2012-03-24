<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('Sorteios Realizados');?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('title', __('Título'));?></th>
				<th><?php echo $this->BootstrapPaginator->sort('created', __('Criado em'));?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($awards as $award): ?>
			<tr>
				<td><?php echo $award['Award']['title']; ?>&nbsp;</td>
				<td><?php echo $this->Locale->datetime($award['Award']['created']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $award['Award']['id'])); ?>
					<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $award['Award']['id'])); ?>
					<?php echo $this->Form->postLink(__('Excluir'), array('action' => 'delete', $award['Award']['id']), null, __('Are you sure you want to delete # %s?', $award['Award']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Ações'); ?></li>
			<li><?php echo $this->Html->link(__('Novo Sorteio'), array('action' => 'add')); ?></li>
		</ul>
	</div>
</div>