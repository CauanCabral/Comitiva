<ul class="nav nav-tabs nav-stacked span2">
	<li><?php echo $this->Html->link(__('Novo usuário'), array('action' => 'add')); ?></li>
</ul>
<div class="span10">
	<div class="row-fluid">
		<div class="span9">
			<h2><?php echo __('Usuários');?></h2>
		</div>
		<div class="span2">
			<?php echo $this->element('search'); ?>
		</div>
	</div>
	<table class="table table-striped table-bordered table-condensed">
	<tr>
		<th><?php echo $this->Paginator->sort('id');?></th>
		<th><?php echo $this->Paginator->sort('name', __('Nome'));?></th>
		<th><?php echo $this->Paginator->sort('username', __('Nome de usuário'));?></th>
		<th><?php echo $this->Paginator->sort('email', __('Email'));?></th>
		<th><?php echo $this->Paginator->sort('last_access', __('Último acesso'));?></th>
		<th><?php echo $this->Paginator->sort('created', __('Data de registro'));?></th>
		<th class="actions"><?php echo __('Ações');?></th>
	</tr>
	<?php
	foreach ($users as $user):
	?>
		<tr>
			<td>
				<?php echo $user['User']['id']; ?>
			</td>
			<td>
				<?php echo $user['User']['fullName']; ?>
			</td>
			<td>
				<?php echo $user['User']['username']; ?>
			</td>
			<td>
				<?php echo $user['User']['email']; ?>
			</td>
			<td>
				<?php echo $this->Locale->date($user['User']['last_access']); ?>
			</td>
			<td>
				<?php echo $this->Locale->dateTime($user['User']['created']); ?>
			</td>
			<td class="actions">
				<?php
					echo $this->Html->link(__('Ver'), array('action' => 'view', $user['User']['id']), array('glyph' => true, 'icon' => 'file large')),
						$this->Html->link(__('Alterar'), array('action' => 'edit', $user['User']['id']), array('glyph' => true, 'icon' => 'edit large')),
						$this->Html->link(__('Remover'), array('action' => 'delete', $user['User']['id']), array('glyph' => true, 'icon' => 'trash large'), sprintf(__('Deseja realmente excluir o usuário %s?'), $user['User']['name']));
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php echo $this->element('paginate'); ?>
</div>