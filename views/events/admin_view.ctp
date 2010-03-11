<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Alterar Evento', true), array('action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $html->link(__('Remover Evento', true), array('action' => 'delete', $event['Event']['id']), null, sprintf(__('Deseja realmente excluir o evento "%s"?', true), $event['Event']['title'])); ?> </li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Evento', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('Adicionar Sub-evento', true), array('controller' => 'events', 'action' => 'add'));?> </li>
	</ul>
</div>
<div class="events view">
<h2><?php  __('Evento');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Descrição'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Macro Evento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($event['ParentEvent']['title'], array('controller' => 'events', 'action' => 'view', $event['ParentEvent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gratuito'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['free'] == TRUE ? __('Sim') : __('Não'); ?>
			&nbsp;
		</dd>
	</dl>
	<br />
	<div class="related">
		<h3><?php __('Sub-eventos');?></h3>
		<?php if (!empty($event['ChildEvent'])):?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php __('Nome'); ?></th>
			<th><?php __('Descrição'); ?></th>
			<th><?php __('Macro Evento'); ?></th>
			<th><?php __('Gratuito'); ?></th>
			<th class="actions"><?php __('Ações');?></th>
		</tr>
		<?php
			$i = 0;
			foreach ($event['ChildEvent'] as $childEvent):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td><?php echo $childEvent['title'];?></td>
				<td><?php echo $childEvent['description'];?></td>
				<td><?php echo $childEvent['ParentEvent']['title'];?></td>
				<td><?php $childEvent['free'] == TRUE ? __('Sim') : __('Não');?></td>
				<td class="actions">
					<?php echo $html->link(__('View', true), array('controller' => 'events', 'action' => 'view', $childEvent['id'])); ?>
					<?php echo $html->link(__('Edit', true), array('controller' => 'events', 'action' => 'edit', $childEvent['id'])); ?>
					<?php echo $html->link(__('Delete', true), array('controller' => 'events', 'action' => 'delete', $childEvent['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $childEvent['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
	</div>
</div>
