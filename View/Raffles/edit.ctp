<div class="raffles form">
<?php echo $this->Form->create('Raffle');?>
	<fieldset>
		<legend><?php echo __('Edit Raffle'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Raffle.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Raffle.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Raffles'), array('action' => 'index'));?></li>
	</ul>
</div>
