<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Novo evento', true), array('controller' => 'events', 'action' => 'add')); ?></li>
	</ul>
</div>
<div class="events index">
<h2><?php __('Eventos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, exibindo %current% entradas de %count% total, iniciando no registro %start% e terminando em %end%', TRUE)
));
?>
</p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('Título', TRUE), 'Event.title');?></th>
	<th><?php echo $paginator->sort(__('Gratuito?', TRUE), 'Event.free');?></th>
  <th><?php echo $paginator->sort(__('Submissão de Propostas liberada?', TRUE), 'Event.open_for_proposals');?></th>
	<th><?php echo __('Inscritos',1);?></th>
	<th class="actions"><?php __('Ações');?></th>
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
			<?php $event['Event']['free'] == TRUE ? __('Sim') : __('Não'); ?>
		</td>
     <td>
			<?php echo $event['Event']['open_for_proposals'] ? __('Sim') : __('Não'); ?>
		</td>
		<td>
			<?php echo $this->Html->link($event['Event']['subscription_count'], array('controller' => 'subscriptions', 'action' => 'index', $event['Event']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Visualizar', true), array('action' => 'view', $event['Event']['id'])); ?>
			<?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $event['Event']['id'])); ?>
			<?php echo $this->Html->link(__('Ver inscrições', true), array('controller' => 'subscriptions', 'action' => 'index', $event['Event']['id'])); ?>
			<?php echo $this->Html->link(__('Apagar', true), array('action' => 'delete', $event['Event']['id']), null, sprintf(__('Tem certeza que deseja apagar # %s?', true), $event['Event']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('próximo', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>