<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar Inscrição', true), array('action' => 'edit', $subscription['Subscription']['id'])); ?> </li>
		<li><?php echo $html->link(__('Apagar Inscrição', true), array('action' => 'delete', $subscription['Subscription']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $subscription['Subscription']['id'])); ?> </li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Listar Usuários', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Usuário', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Evento', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Listar Pagamentos', true), array('controller' => 'payments', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Pagamento', true), array('controller' => 'payments', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="subscriptions view">
<h2><?php  __('Inscrição',1);?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Usuário',1); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($subscription['User']['name'], array('controller' => 'users', 'action' => 'view', $subscription['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Evento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Criado',1); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->data($subscription['Subscription']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php __('Pagamentos relacionados');?></h3>
	<?php if (!empty($subscription['Payment'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Data',1); ?></th>
		<th><?php __('Quantia',1); ?></th>
		<th><?php __('Informação',1); ?></th>
		<th><?php __('Confirmado?',1); ?></th>
		<th><?php __('Criado em',1); ?></th>
		<th><?php __('Modificado em',1); ?></th>
		<th class="actions"><?php __('Ações', 1);?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($subscription['Payment'] as $payment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $payment['date'];?></td>
			<td><?php echo $payment['amount'];?></td>
			<td><?php echo $payment['information'];?></td>
			<td><?php echo $payment['confirmed'];?></td>
			<td><?php echo $payment['created'];?></td>
			<td><?php echo $payment['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Ver', true), array('controller' => 'payments', 'action' => 'view', $payment['id'])); ?>
				<?php echo $html->link(__('Editar', true), array('controller' => 'payments', 'action' => 'edit', $payment['id'])); ?>
				<?php echo $html->link(__('Apagar', true), array('controller' => 'payments', 'action' => 'delete', $payment['id']), null, sprintf(__('Tem certeza que deseja apagar # %s?', true), $payment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
