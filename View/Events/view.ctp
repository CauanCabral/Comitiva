<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->glyphLink(__('Cria uma conta'), '/', array('glyph' => 'glyph-user glyph-large')); ?></li>
		<li><?php echo $this->Html->glyphLink(__('Inscrever-se'), array('prefix' => 'participant', 'controller' => 'subscriptions', 'action' => 'add', $event['Event']['id']), array('glyph' => 'glyph-signin glyph-large')); ?></li>
	</ul>

	<div class="span10">
	<h2><?php echo __('Evento');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Inscritos'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['subscription_count']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Descrição'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Macro Evento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($event['ParentEvent']['title'], array('controller' => 'events', 'action' => 'view', $event['ParentEvent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Gratuito'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['free'] ? __('Sim') : __('Não'); ?>
			&nbsp;
		</dd>
	</dl>

	<h3><?php echo __('Pagamento')?></h3>
	<p><?php echo Configure::read('Comitiva.paymentInfo'); ?></p>

	<?php if (!empty($event['EventDate'])):?>
		<h3><?php echo __('Datas');?></h3>

		<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo __('Legenda'); ?></th>
			<th><?php echo __('Data'); ?></th>
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
				<td><?php echo $this->Locale->dateTime($eventDate['date']);?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	<?php if (!empty($event['EventPrice'])):?>
		<h3><?php echo __('Valores');?></h3>
		<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo __('Observação');?></th>
			<th><?php echo __('Valor'); ?></th>
			<th><?php echo __('Período'); ?></th>
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
				<td><?php echo $this->Locale->currency($eventPrice['price']);?></td>
				<td><?php echo __('entre'), ' ', $this->Locale->date($eventPrice['start_date']), ' ', __('e'), ' ',$this->Locale->date($eventPrice['final_date']);?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	<?php if (!empty($event['ChildEvent'])):?>
		<h3><?php echo __('Sub-eventos');?></h3>
		<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo __('Nome'); ?></th>
			<th><?php echo __('Descrição'); ?></th>
			<th><?php echo __('Gratuito'); ?></th>
			<th class="actions"><?php echo __('Ações');?></th>
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
				<td><?php echo $childEvent['free'] ? __('Sim') : __('Não');?></td>
				<td class="actions">
					<?php echo $this->Html->glyphLink(__('Inscrever-se'), array('controller' => 'subscriptions' ,'action' => 'add', $childEvent['id']), array('glyph' => 'glyph-signin glyph-large')); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
	</div>
</div>