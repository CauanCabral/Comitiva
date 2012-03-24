<div class="raffles index">
	<ul  class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Novo Sorteio'), array('action' => 'new')); ?></li>
	</ul>
	<div class="span10">
		<h2><?php echo __('Sorteados');?></h2>
		<table  class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo $this->Paginator->sort('Award.title', __('Premiação'));?></th>
			<th><?php echo $this->Paginator->sort('User.name', __('Ganhador'));?></th>
			<th><?php echo $this->Paginator->sort('created', __('Registrado em'));?></th>
			<th class="actions"><?php echo __('Ações');?></th>
		</tr>
		<?php
		foreach ($raffles as $raffle): ?>
		<tr>
			<td><?php echo $raffle['Award']['title']; ?>&nbsp;</td>
			<td><?php echo $raffle['User']['name']; ?>&nbsp;</td>
			<td><?php echo $this->Locale->datetime($raffle['Raffle']['created']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->glyphLink(__('Visualizar'), array('action' => 'view', $raffle['Raffle']['id']), array('glyph' => 'glyph-file glyph-large') ); ?>
				<?php echo $this->Html->glyphLink(__('Excluir'), array('action' => 'delete', $raffle['Raffle']['id']),  array('glyph' => 'glyph-trash glyph-large'), __('Deseja excluir o sorteado?')); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
		<?php echo $this->element('paginate'); ?>
	</div>
</div>
