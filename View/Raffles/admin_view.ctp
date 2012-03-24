<div class="raffles view">
<h2><?php  echo __('Raffle');?></h2>
	<dl>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($raffle['Raffle']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($raffle['Raffle']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($raffle['Raffle']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Raffle'), array('action' => 'edit', $raffle['Raffle']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Raffle'), array('action' => 'delete', $raffle['Raffle']['id']), null, __('Are you sure you want to delete # %s?', $raffle['Raffle']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Raffles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Raffle'), array('action' => 'add')); ?> </li>
	</ul>
</div>
