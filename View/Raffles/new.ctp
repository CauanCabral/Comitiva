<div class="raffles form">
<?php echo $this->Form->create('Raffle');?>
	<fieldset>
		<legend><?php echo __('Add Raffle'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Raffles'), array('action' => 'index'));?></li>
	</ul>
</div>
