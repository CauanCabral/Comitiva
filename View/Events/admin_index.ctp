<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Novo evento'), array('controller' => 'events', 'action' => 'add')); ?></li>
	</ul>
</div>
<div class="events index">
<h2><?php echo __('Eventos');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Página %page% de %pages%, exibindo %current% entradas de %count% total, iniciando no registro %start% e terminando em %end%')
));
?>
</p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('Event.title', __('Título'));?></th>
	<th><?php echo $this->Paginator->sort('Event.free', __('Gratuito?'));?></th>
  <th><?php echo $this->Paginator->sort('Event.open_for_proposals', __('Submissão de Propostas liberada?'));?></th>
	<th><?php echo __('Inscritos',true);?></th>
	<th class="actions"><?php echo __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($events as $event):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
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
			<?php echo $this->Html->link(__('Visualizar'), array('action' => 'view', $event['Event']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $event['Event']['id'])); ?>
			<?php echo $this->Html->link(__('Ver inscrições'), array('controller' => 'subscriptions', 'action' => 'index', $event['Event']['id'])); ?>
			<?php echo $this->Html->link(__('Apagar'), array('action' => 'delete', $event['Event']['id']), null, sprintf(__('Tem certeza que deseja apagar # %s?'), $event['Event']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('anterior'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('próximo').' >>', array(), null, array('class' => 'disabled'));?>
</div>