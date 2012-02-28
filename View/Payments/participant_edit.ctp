<div class="payments form">
<?php echo $this->Form->create('Payment');?>
	<fieldset>
 		<legend><?php echo __('Edit Payment');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('subscription_id');
		echo $this->Form->input('date');
		echo $this->Form->input('amount');
		echo $this->Form->input('information');
		echo $this->Form->input('confirmed');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Payment.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Payment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Payments'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Subscriptions'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subscription'), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>