<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Editar Inscrição'), array('action' => 'edit', $subscription['Subscription']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Apagar Inscrição'), array('action' => 'delete', $subscription['Subscription']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $subscription['Subscription']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Inscrição'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Pagamentos'), array('controller' => 'payments', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions view">
<h2><?php echo __('Inscrição',1);?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Usuário'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($subscription['User']['fullName'], array('controller' => 'users', 'action' => 'view', $subscription['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Evento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Criado'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Locale->date($subscription['Subscription']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php if (isset($subscription['Payment']['id'])):?>
<div class="related">
	<h3><?php echo __('Pagamentos relacionados');?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('Valor'); ?></th>
		<th><?php echo __('Informação'); ?></th>
		<th><?php echo __('Confirmado?'); ?></th>
		<th><?php echo __('Criado em'); ?></th>
		<th><?php echo __('Ações'); ?></th>
	</tr>
	<tr<?php echo $class;?>>
		<td><?php echo $this->Locale->date($subscription['Payment']['date']);?></td>
		<td><?php echo $this->Locale->currency($subscription['Payment']['amount']);?></td>
		<td><?php echo $subscription['Payment']['information'];?></td>
		<td><?php $subscription['Payment']['confirmed'] ? __('Sim') : __('Não');?></td>
		<td><?php echo $this->Locale->date($subscription['Payment']['created']);?></td>
		<td class="actions">
			<?php
			if(!$subscription['Event']['free'] && !$subscription['Payment']['confirmed'])
				echo $this->Html->link(__('Confirmar pagamento', TRUE), array('controller' => 'payments', 'action' => 'confirm', $subscription['Payment']['id']), null, sprintf(__('Deseja realmente confirmar o pagamento da inscrição # %s?'), $subscription['Payment']['id']));
					
			echo $this->Html->link(__('Ver', TRUE), array('controller' => 'payments', 'action' => 'view', $subscription['Payment']['id']));
			?>
		</td>
	</tr>
	</table>
</div>
<?php endif; ?>