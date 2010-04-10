<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar Inscrição', true), array('action' => 'edit', $subscription['Subscription']['id'])); ?> </li>
		<li><?php echo $html->link(__('Apagar Inscrição', true), array('action' => 'delete', $subscription['Subscription']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $subscription['Subscription']['id'])); ?> </li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Pagamentos', true), array('controller' => 'payments', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions view">
<h2><?php  __('Inscrição',1);?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Usuário'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($subscription['User']['fullName'], array('controller' => 'users', 'action' => 'view', $subscription['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Evento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Criado'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->data($subscription['Subscription']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php if (isset($subscription['Payment']['id'])):?>
<div class="related">
	<h3><?php __('Pagamentos relacionados');?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Data'); ?></th>
		<th><?php __('Valor'); ?></th>
		<th><?php __('Informação'); ?></th>
		<th><?php __('Confirmado?'); ?></th>
		<th><?php __('Criado em'); ?></th>
		<th><?php __('Ações'); ?></th>
	</tr>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Formatacao->data($subscription['Payment']['date']);?></td>
		<td><?php echo $this->Formatacao->moeda($subscription['Payment']['amount']);?></td>
		<td><?php echo $subscription['Payment']['information'];?></td>
		<td><?php $subscription['Payment']['confirmed'] ? __('Sim') : __('Não');?></td>
		<td><?php echo $this->Formatacao->data($subscription['Payment']['created']);?></td>
		<td class="actions">
			<?php
			if(!$subscription['Event']['free'] && !$subscription['Payment']['confirmed'])
				echo $html->link(__('Confirmar pagamento', TRUE), array('controller' => 'payments', 'action' => 'confirm', $subscription['Payment']['id']), null, sprintf(__('Deseja realmente confirmar o pagamento da inscrição # %s?', true), $subscription['Payment']['id']));
					
			echo $this->Html->link(__('Ver', TRUE), array('controller' => 'payments', 'action' => 'view', $subscription['Payment']['id']));
			?>
		</td>
	</tr>
	</table>
</div>
<?php endif; ?>