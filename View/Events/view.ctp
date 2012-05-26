
<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Inscrever Neste Evento'), array('participant' => true, 'controller' => 'subscriptions', 'action' => 'add', $event['Event']['id']), array('class' => '')); ?> </li>
		<li><?php echo $this->Html->link(__('Cria uma Conta'), '/account_create', array('class' => '')); ?> </li>
	</ul>
<div class="span10">
	<header>
	<h1>
		<?php echo $event['Event']['title']; ?>
		<small><?php echo $event['Event']['lead'];?></small>
	</h1>
</header>

	<div class="event-info"> 
		<h3><?php echo "Informações " ?></h3>
		<div class="well"><?php echo $event['Event']['description']; ?></div>
		<br/>
		<?php if(isset($event['ParentEvent']['title'])): ?>
		<h3><?php echo "Macro evento" ?></h3>
			<p><?php echo $this->Html->link($event['ParentEvent']['title'], array('controller' => 'events', 'action' => 'view', $event['ParentEvent']['id']));?></p>
		<?php endif; ?>
		<h3><?php echo "Entrada " ?></h3>
		<p><?php echo $event['Event']['free'] ? __('Entrada Franca') : __('Possui taxa de inscrição'); ?> </p>
	</div>
	<?php if(!$event['Event']['free'] && isset($event['Event']['payment_info'])): ?>
		<h3><?php echo __('Pagamento')?></h3>

		<?php echo $event['Event']['payment_info']; ?>
	<?php endif; ?>
	<br/>
	<?php if (!empty($event['EventDate'])):?>
		<h3><?php echo __('Datas');?></h3>
		<?php
			foreach ($event['EventDate'] as $eventDate):
			?>
				<b><?php echo $eventDate['desc'];?></b>
				<p><?php echo $this->Locale->dateTime($eventDate['date']);?></p>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	<br/>
	<?php if (!empty($event['EventPrice'])):?>
		<h3><?php echo __('Taxas de Participação');?></h3>
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
					<?php echo $this->Html->link(__('Inscrever-se'), array('controller' => 'subscriptions' ,'action' => 'add', $childEvent['id']), array('glyph' => true, 'icon' => 'signin large')); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>