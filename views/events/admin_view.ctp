<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Alterar Evento', true), array('action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $html->link(__('Ver inscrições', true), array('controller' => 'subscriptions', 'action' => 'index', $event['Event']['id'])); ?> </li>
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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Inscritos'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($event['Event']['subscription_count'], array('controller' => 'subscriptions', 'action' => 'index', $event['Event']['id'])); ?>
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
	
	<?php if (!empty($event['EventDate'])):?>
	<br />
	<div class="related">
		<h3><?php __('Datas');?></h3>
		
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php __('Legenda'); ?></th>
			<th><?php __('Data'); ?></th>
		</tr>
		<?php
			$i = 0;
			foreach ($event['EventDate'] as $eventDate):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td><?php echo $eventDate['desc'];?></td>
				<td><?php echo $this->Formatacao->dataHora($eventDate['date']);?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
	<?php endif; ?>
	
	<?php if (!empty($event['EventPrice'])):?>
	<br />
	<div class="related">
		<h3><?php __('Valores');?></h3>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php __('Observação');?></th>
			<th><?php __('Valor'); ?></th>
			<th><?php __('Data inicial'); ?></th>
			<th><?php __('Data final'); ?></th>
		</tr>
		<?php
			$i = 0;
			foreach ($event['EventPrice'] as $eventPrice):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td><?php echo $eventPrice['observation'];?></td>
				<td><?php echo $this->Formatacao->moeda($eventPrice['price']);?></td>
				<td><?php echo $this->Formatacao->data($eventPrice['start_date']);?></td>
				<td><?php echo $this->Formatacao->data($eventPrice['final_date']);?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
	<?php endif; ?>
	
	<?php if (!empty($event['ChildEvent'])):?>
	<br />
	<div class="related">
		<h3><?php __('Sub-eventos');?></h3>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php __('Nome'); ?></th>
			<th><?php __('Descrição'); ?></th>
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
				<td><?php $childEvent['free'] == TRUE ? __('Sim') : __('Não');?></td>
				<td class="actions">
					<?php echo $html->link(__('Visualizar', true), array('controller' => 'events', 'action' => 'view', $childEvent['id'])); ?>
					<?php echo $html->link(__('Alterar', true), array('controller' => 'events', 'action' => 'edit', $childEvent['id'])); ?>
					<?php echo $html->link(__('Remover', true), array('controller' => 'events', 'action' => 'delete', $childEvent['id']), null, sprintf(__('Deseja realmente excluir o evento \'%s\'?', true), $childEvent['title'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
	<?php endif; ?>
</div>
