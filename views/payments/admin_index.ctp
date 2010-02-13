<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Novo Pagamento', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments index">
<h2><?php __('Payments');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% entradas de %count% total, començando na entrada %start%, terminando em %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('subscription_id');?></th>
	<th><?php echo $paginator->sort('date');?></th>
	<th><?php echo $paginator->sort('amount');?></th>
	<th><?php echo $paginator->sort('information');?></th>
	<th><?php echo $paginator->sort('confirmed');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Ações',1);?></th>
</tr>
<?php
$i = 0;
foreach ($payments as $payment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $payment['Payment']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($payment['Subscription']['id'], array('controller' => 'subscriptions', 'action' => 'view', $payment['Subscription']['id'])); ?>
		</td>
		<td>
			<?php echo $payment['Payment']['date']; ?>
		</td>
		<td>
			<?php echo $payment['Payment']['amount']; ?>
		</td>
		<td>
			<?php echo $payment['Payment']['information']; ?>
		</td>
		<td>
			<?php echo $payment['Payment']['confirmed']; ?>
		</td>
		<td>
			<?php echo $payment['Payment']['created']; ?>
		</td>
		<td>
			<?php echo $payment['Payment']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Visualizar', true), array('action' => 'view', $payment['Payment']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action' => 'edit', $payment['Payment']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action' => 'delete', $payment['Payment']['id']), null, sprintf(__('Tem certeza que deseja apagar # %s?', true), $payment['Payment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('próxima', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>