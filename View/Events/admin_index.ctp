<ul class="nav nav-tabs nav-stacked span3">
	<li><?php echo $this->Html->link(__('Novo evento'), array('controller' => 'events', 'action' => 'add')); ?></li>
</ul>
<div class="events index span10">
<h2><?php echo __('Eventos');?></h2>
<table class="table table-striped table-bordered table-condensed">
<tr>
	<th><?php echo $this->Paginator->sort('Event.title', __('Título'));?></th>
	<th><?php echo $this->Paginator->sort('Event.free', __('Gratuito?'));?></th>
  <th><?php echo $this->Paginator->sort('Event.open_for_proposals', __('Submissão de Propostas liberada?'));?></th>
	<th><?php echo __('Inscritos');?></th>
	<th class="actions"><?php echo __('Ações');?></th>
</tr>
<?php
foreach ($events as $event):
?>
	<tr>
		<td>
			<?php echo $event['Event']['title']; ?>
		</td>
		<td>
			<?php $event['Event']['free'] == true ? __('Sim') : __('Não'); ?>
		</td>
     <td>
			<?php echo $event['Event']['open_for_proposals'] ? __('Sim') : __('Não'); ?>
		</td>
		<td>
			<?php echo $this->Html->link($event['Event']['subscription_count'], array('controller' => 'subscriptions', 'action' => 'index', $event['Event']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->glyphLink(__('Visualizar'), array('action' => 'view', $event['Event']['id']), array('glyph' => 'glyph-file glyph-large')),
				$this->Html->link(__('Editar'), array('action' => 'edit', $event['Event']['id'])),
				$this->Html->link(__('Ver inscrições'), array('controller' => 'subscriptions', 'action' => 'index', $event['Event']['id'])),
				$this->Html->link(__('Apagar'), array('action' => 'delete', $event['Event']['id']), null, sprintf(__('Tem certeza que deseja apagar # %s?'), $event['Event']['id']));
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php
echo $this->element('paginate');