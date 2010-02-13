<div class="payments index">
<h2><?php __('Payments');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
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
	<th class="actions"><?php __('Actions');?></th>
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
			<?php echo $html->link(__('View', true), array('action' => 'view', $payment['Payment']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $payment['Payment']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $payment['Payment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $payment['Payment']['id'])); ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Payment', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Subscriptions', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Subscription', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>