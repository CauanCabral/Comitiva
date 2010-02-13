<div class="events view">
<h2><?php  __('Event');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Event'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($event['ParentEvent']['title'], array('controller' => 'events', 'action' => 'view', $event['ParentEvent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Free'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['free']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Event', true), array('action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Event', true), array('action' => 'delete', $event['Event']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $event['Event']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Events', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Parent Event', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Event Dates', true), array('controller' => 'event_dates', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event Date', true), array('controller' => 'event_dates', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Event Prices', true), array('controller' => 'event_prices', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event Price', true), array('controller' => 'event_prices', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Subscriptions', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Subscription', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Event Dates');?></h3>
	<?php if (!empty($event['EventDate'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Event Id'); ?></th>
		<th><?php __('Date'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($event['EventDate'] as $eventDate):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $eventDate['id'];?></td>
			<td><?php echo $eventDate['event_id'];?></td>
			<td><?php echo $eventDate['date'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'event_dates', 'action' => 'view', $eventDate['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'event_dates', 'action' => 'edit', $eventDate['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'event_dates', 'action' => 'delete', $eventDate['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $eventDate['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Event Date', true), array('controller' => 'event_dates', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Event Prices');?></h3>
	<?php if (!empty($event['EventPrice'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Event Id'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('Start Date'); ?></th>
		<th><?php __('Final Date'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($event['EventPrice'] as $eventPrice):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $eventPrice['id'];?></td>
			<td><?php echo $eventPrice['event_id'];?></td>
			<td><?php echo $eventPrice['price'];?></td>
			<td><?php echo $eventPrice['start_date'];?></td>
			<td><?php echo $eventPrice['final_date'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'event_prices', 'action' => 'view', $eventPrice['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'event_prices', 'action' => 'edit', $eventPrice['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'event_prices', 'action' => 'delete', $eventPrice['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $eventPrice['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Event Price', true), array('controller' => 'event_prices', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Events');?></h3>
	<?php if (!empty($event['ChildEvent'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Parent Id'); ?></th>
		<th><?php __('Free'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($event['ChildEvent'] as $childEvent):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $childEvent['id'];?></td>
			<td><?php echo $childEvent['title'];?></td>
			<td><?php echo $childEvent['description'];?></td>
			<td><?php echo $childEvent['parent_id'];?></td>
			<td><?php echo $childEvent['free'];?></td>
			<td><?php echo $childEvent['created'];?></td>
			<td><?php echo $childEvent['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'events', 'action' => 'view', $childEvent['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'events', 'action' => 'edit', $childEvent['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'events', 'action' => 'delete', $childEvent['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $childEvent['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Child Event', true), array('controller' => 'events', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Subscriptions');?></h3>
	<?php if (!empty($event['Subscription'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Event Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($event['Subscription'] as $subscription):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $subscription['id'];?></td>
			<td><?php echo $subscription['user_id'];?></td>
			<td><?php echo $subscription['event_id'];?></td>
			<td><?php echo $subscription['created'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'subscriptions', 'action' => 'view', $subscription['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'subscriptions', 'action' => 'edit', $subscription['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'subscriptions', 'action' => 'delete', $subscription['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $subscription['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Subscription', true), array('controller' => 'subscriptions', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
