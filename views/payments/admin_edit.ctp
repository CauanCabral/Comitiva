<div class="payments form">
<?php echo $form->create('Payment');?>
	<fieldset>
 		<legend><?php __('Edit Payment');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('subscription_id');
		echo $form->input('date');
		echo $form->input('amount');
		echo $form->input('information');
		echo $form->input('confirmed');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Payment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Payment.id'))); ?></li>
		<li><?php echo $html->link(__('List Payments', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Subscriptions', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Subscription', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>