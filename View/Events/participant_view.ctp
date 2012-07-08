<?php
$eventLink = Router::url("/divulgacao/{$event['Event']['alias']}", true);
?>
<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Inscrever neste evento'), array('controller' => 'subscriptions', 'action' => 'add',$event['Event']['id'])); ?> </li>
	</ul>

	<div class="span10">
		<div class="page-header">
			<h1>
				<?php echo $event['Event']['title'];?>
				<small><?php echo $event['Event']['lead']; ?></small>
			</h1>
		</div>

		<?php if(isset($event['ParentEvent']) && !empty($event['ParentEvent']['id'])): ?>
			<h4><?php echo sprintf(__('Este evento faz parte do "%s"'), $this->Html->link($event['ParentEvent']['title'], array('controller' => 'events', 'action' => 'view', $event['ParentEvent']['id']))); ?></h4>

			<hr>
		<?php endif; ?>

		<h3><i class="glyph-file"></i><?php echo __('Mais informações'); ?></h3>
		<div class="well">
			<?php echo $event['Event']['description']; ?>
		</div>

		<hr>

		<?php if (!empty($event['EventDate'])):?>
			<h3><i class="glyph-calendar"></i><?php echo __('Datas');?></h3>
			<dl>
			<?php foreach ($event['EventDate'] as $eventDate): ?>
				<dt><?php echo $eventDate['desc'];?></dt>
				<dd><?php echo $this->Locale->dateTime($eventDate['date']);?></dd>
			<?php endforeach; ?>
			</dl>
		<?php endif; ?>

		<hr>

		<?php if(!$event['Event']['free']): ?>
			<h3><i class="glyph-credit-card"></i><?php echo __('Tipos e períodos de inscrição')?></h3>
		<?php else: ?>
			<h3><i class="glyph-gift"></i><?php echo __('Inscrição gratuita'); ?></h3>
		<?php endif; ?>

		<?php if(!empty($event['Event']['payment_info'])): ?>
			<?php echo $event['Event']['payment_info']; ?>
			<br>
		<?php endif; ?>

		<?php if (!empty($event['EventPrice'])):?>
			<table class="table table-striped table-bordered table-condensed">
			<tr>
				<th><?php echo __('Observação');?></th>
				<th><?php echo __('Valor'); ?></th>
				<th><?php echo __('Período'); ?></th>
			</tr>
			<?php foreach ($event['EventPrice'] as $eventPrice): ?>
				<tr>
					<td><?php echo $eventPrice['observation'];?></td>
					<td><?php echo $this->Locale->currency($eventPrice['price']);?></td>
					<td><?php echo __('entre'), ' ', $this->Locale->date($eventPrice['start_date']), ' ', __('e'), ' ',$this->Locale->date($eventPrice['final_date']);?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>

		<hr>

		<?php if (!empty($event['ChildEvent'])):?>
			<h3><?php echo __('Sub-eventos');?></h3>
			<table class="table table-striped table-bordered table-condensed">
			<tr>
				<th><?php echo __('Nome'); ?></th>
				<th><?php echo __('Descrição'); ?></th>
				<th><?php echo __('Gratuito'); ?></th>
				<th class="actions"><?php echo __('Ações');?></th>
			</tr>
			<?php foreach ($event['ChildEvent'] as $childEvent): ?>
				<tr>
					<td><?php echo $childEvent['title'];?></td>
					<td><?php echo $childEvent['description'];?></td>
					<td><?php echo $childEvent['free'] ? __('Sim') : __('Não');?></td>
					<td class="actions">
						<?php echo $this->Html->link(__('Inscrever-se'), array('controller' => 'subscriptions' ,'action' => 'add', $childEvent['id']), array('glyph' => true, 'icon' => 'signin large')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
</div>