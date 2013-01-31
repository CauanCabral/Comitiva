<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Certified Model');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Attachment Id'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['attachment_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Event Id'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['event_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modified'); ?></dt>
			<dd>
				<?php echo h($certifiedModel['CertifiedModel']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Certified Model')), array('action' => 'edit', $certifiedModel['CertifiedModel']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Certified Model')), array('action' => 'delete', $certifiedModel['CertifiedModel']['id']), null, __('Are you sure you want to delete # %s?', $certifiedModel['CertifiedModel']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Certified Models')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Certified Model')), array('action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
<div>

