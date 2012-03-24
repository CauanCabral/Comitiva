<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar usuários'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Alterar usuário'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Remover usuário'), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Deseja realmente excluir # %s?'), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Novo usuário'), array('action' => 'add')); ?> </li>
	</ul>
	<div class="span10">
	<h2><?php echo __('Usuário');?></h2>
		<dl><?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Nome'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $user['User']['name']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Sobrenome'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $user['User']['nickname']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Data de nascimento'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Locale->date($user['User']['birthday']); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Nome de usuário'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $user['User']['username']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Email'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $user['User']['email']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Último acesso'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Locale->dateTime($user['User']['last_access']); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Data de registro'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Locale->dateTime($user['User']['created']); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Última alteração'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Locale->dateTime($user['User']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<h3><?php echo __('Inscrições do usuário');?></h3>
	<?php if (!empty($user['Subscription'])):?>

	<table class="table table-striped table-bordered table-condensed">
	<tr>
		<th><?php echo __('Evento'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th class="actions"><?php echo __('Ações');?></th>
	</tr>
	<?php
	foreach ($user['Subscription'] as $subscription):
	?>
		<tr<?php echo $class;?>>
			<td><?php echo $subscription['Event']['title'];?></td>
			<td><?php echo $this->Locale->date($subscription['Event']['created']);?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Ver'), array('controller' => 'subscriptions', 'action' => 'view', $subscription['id'])); ?>
				<?php echo $this->Html->link(__('Alterar'), array('controller' => 'subscriptions', 'action' => 'edit', $subscription['id'])); ?>
				<?php echo $this->Html->link(__('Remover'), array('controller' => 'subscriptions', 'action' => 'delete', $subscription['id']), null, sprintf(__('Deseja realmente excluir # %s?'), $subscription['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>

	<?php endif; ?>
</div>