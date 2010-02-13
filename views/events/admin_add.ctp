<div class="events form">
<?php echo $form->create('Event');?>
	<fieldset>
 		<legend><?php __('Add Event');?></legend>
	<?php
		echo $form->input('title');
		echo $form->input('description');
		echo $form->input('parent_id');
		echo $form->input('free');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Events', true), array('action' => 'index'));?></li>
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