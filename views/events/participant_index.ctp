<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Minhas Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="events index">
<h2><?php __('Eventos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registros de um total de %count% , começando em %start%, terminando em %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('free');?></th>
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
			<?php echo $event['Event']['id']; ?>
		</td>
		<td>
			<?php echo $event['Event']['title']; ?>
		</td>
		<td>
			<?php echo $event['Event']['free']?__('Sim'):__('Não'); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Visualizar', true), array('action' => 'view', $event['Event']['id'])); ?>
			<?php echo $html->link(__('Inscrever-se', true), array('controller' => 'subscriptions' ,'action' => 'add', $event['Event']['id']), null, sprintf(__('Tem certeza que deseja inscrever-se no evento %s?', true), $event['Event']['title'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('Página Anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('Próxima Página', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
