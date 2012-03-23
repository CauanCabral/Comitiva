<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Novo usuário'), array('action' => 'add')); ?></li>
	</ul>
</div>
<div class="users index">
<h2><?php echo __('Usuários');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Página %page% de %pages%, exibindo %current% entradas de %count% total, iniciando no registro %start% e terminando em %end%')
));
?></p>
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
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
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
			<?php echo $this->Locale->date($user['User']['created']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Alterar'), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Remover'), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Deseja realmente excluir # %s?'), $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php
echo $this->element('paginate');