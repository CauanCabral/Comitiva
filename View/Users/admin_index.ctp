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
'format' => __('Página %page% de %pages%, exibindo %current% entradas de %count% total, iniciando no registro %start% e terminando em %end%', TRUE)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort(__('Nome', TRUE), 'name');?></th>
	<th><?php echo $this->Paginator->sort(__('Nome de usuário', TRUE), 'username');?></th>
	<th><?php echo $this->Paginator->sort(__('Email', TRUE), 'email');?></th>
	<th><?php echo $this->Paginator->sort(__('Último acesso', TRUE), 'last_access');?></th>
	<th><?php echo $this->Paginator->sort(__('Data de registro', TRUE), 'created');?></th>
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
			<?php echo $this->Formatacao->data($user['User']['last_access']); ?>
		</td>
		<td>
			<?php echo $this->Formatacao->data($user['User']['created']); ?>
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
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('anterior'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('próximo').' >>', array(), null, array('class' => 'disabled'));?>
</div>