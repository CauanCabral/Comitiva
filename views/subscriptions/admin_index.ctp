<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('Listar Usuários', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Usuário', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Evento', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Listar Pagamentos', true), array('controller' => 'payments', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Pagamento', true), array('controller' => 'payments', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="subscriptions index">
<h2><?php __('Inscrições',1);?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registros de %count% total, começando na entrada %start%, terminando em %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('event_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th class="actions"><?php __('Ações',1);?></th>
</tr>
<?php
$i = 0;
foreach ($subscriptions as $subscription):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $subscription['Subscription']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($subscription['User']['name'], array('controller' => 'users', 'action' => 'view', $subscription['User']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
		</td>
		<td>
			<?php echo $subscription['Subscription']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Visualizar', true), array('action' => 'view', $subscription['Subscription']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action' => 'edit', $subscription['Subscription']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action' => 'delete', $subscription['Subscription']['id']), null, sprintf(__('Tem certeza que deseja deletar # %s?', true), $subscription['Subscription']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('próxima', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>