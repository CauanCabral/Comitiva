<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Novo usuário', true), array('action' => 'add')); ?></li>
	</ul>
</div>
<div class="users index">
<h2><?php __('Usuários');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, exibindo %current% entradas de %count% total, iniciando no registro %start% e terminando em %end%', TRUE)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort(__('Nome', TRUE), 'name');?></th>
	<th><?php echo $paginator->sort(__('Nome de usuário', TRUE), 'username');?></th>
	<th><?php echo $paginator->sort(__('Email', TRUE), 'email');?></th>
	<th><?php echo $paginator->sort(__('Último acesso', TRUE), 'last_access');?></th>
	<th><?php echo $paginator->sort(__('Data de registro', TRUE), 'created');?></th>
	<th class="actions"><?php __('Ações');?></th>
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
			<?php echo $user['User']['name']; ?>
		</td>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
		<td>
			<?php echo $user['User']['last_access']; ?>
		</td>
		<td>
			<?php echo $user['User']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $html->link(__('Alterar', true), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $html->link(__('Remover', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Deseja realmente excluir # %s?', true), $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('próximo', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>