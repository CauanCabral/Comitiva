<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions index">
<h2><?php __('Inscrições');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registros de %count% total, começando na entrada %start%, terminando em %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort(__('Evento', TRUE), 'event_id');?></th>
	<th><?php echo $paginator->sort(__('Data', TRUE), 'created');?></th>
	<th class="actions"><?php __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($subscriptions as $subscription):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $subscription['Subscription']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
		</td>
		<td>
			<?php echo $subscription['Subscription']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action' => 'view', $subscription['Subscription']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
