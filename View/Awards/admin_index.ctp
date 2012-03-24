<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Nova Premiação'), array('action' => 'add')); ?></li>
	</ul>
	<div class="span10">
		<h2><?php echo __('Sorteios Realizados');?></h2>

		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<th><?php echo $this->Paginator->sort('title', __('Título'));?></th>
				<th><?php echo $this->Paginator->sort('created', __('Criado em'));?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
			<?php foreach ($awards as $award): ?>
			<tr>
				<td><?php echo $award['Award']['title']; ?>&nbsp;</td>
				<td><?php echo $this->Locale->datetime($award['Award']['created']); ?>&nbsp;</td>
				<td class="actions">
					<?php
						echo $this->Html->glyphLink(__('Ver'), array('action' => 'view', $award['Award']['id']), array('glyph' => 'glyph-file glyph-large')),
						$this->Html->glyphLink(__('Editar'), array('action' => 'edit', $award['Award']['id']), array('glyph' => 'glyph-file glyph-large')),
						$this->Html->glyphLink(__('Remover'), array('action' => 'delete', $award['Award']['id']), array('glyph' => 'glyph-file glyph-large'), __('Deseja remover a premiação?'));
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php echo $this->element('paginate'); ?>
	</div>
</div>