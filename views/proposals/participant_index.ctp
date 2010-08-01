<div class="proposals index">
	<h2><?php __('Propostas');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('event_id');?></th>
			<th><?php echo $this->Paginator->sort('mini_curriculum');?></th>
			<th><?php echo $this->Paginator->sort('area');?></th>
			<th><?php echo $this->Paginator->sort('abstract');?></th>
			<th><?php echo $this->Paginator->sort('detailed');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($proposals as $proposal):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $proposal['Proposal']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($proposal['User']['name'], array('controller' => 'users', 'action' => 'view', $proposal['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($proposal['Event']['title'], array('controller' => 'events', 'action' => 'view', $proposal['Event']['id'])); ?>
		</td>
		<td><?php echo $proposal['Proposal']['mini_curriculum']; ?>&nbsp;</td>
		<td><?php echo $proposal['Proposal']['area']; ?>&nbsp;</td>
		<td><?php echo $proposal['Proposal']['abstract']; ?>&nbsp;</td>
		<td><?php echo $proposal['Proposal']['detailed']; ?>&nbsp;</td>
		<td><?php echo $proposal['Proposal']['created']; ?>&nbsp;</td>
		<td><?php echo $proposal['Proposal']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $proposal['Proposal']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $proposal['Proposal']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $proposal['Proposal']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $proposal['Proposal']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nova Proposta', true), array('action' => 'add')); ?></li>
	</ul>
</div>