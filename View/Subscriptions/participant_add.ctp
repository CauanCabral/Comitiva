<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
	<div class="span10">
		<?php
			echo $this->Form->create('Subscription', array('action' => 'add' . '/' . $event['Event']['id']));
			echo $this->Form->input('Subscription.confirm', array('type' => 'hidden', 'value' => sha1($event['Event']['id'])));
		?>
		<fieldset>
	 		<legend><?php echo __('Confirme sua Inscrição');?></legend>
			<?php
				echo '<h2>', $event['Event']['title'], '</h2>';
				if(!empty($event['ParentEvent']['title'])):
			?>
			<h2><?php echo __('Macro Evento') ?></h2>
			<h3><?php echo $event['ParentEvent']['title']; ?> </h3>
			<?php endif; ?>

			<?php if (!empty($event['EventDate'])):?>
				<h3><?php echo __('Datas');?></h3>

				<table class="table table-striped table-bordered table-condensed">
				<tr>
					<th><?php echo __('Título'); ?></th>
					<th><?php echo __('Data'); ?></th>
				</tr>
				<?php
					foreach ($event['EventDate'] as $eventDate):
					?>
					<tr>
						<td><?php echo $eventDate['desc'];?></td>
						<td><?php echo $this->Locale->dateTime($eventDate['date']);?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php endif; ?>

			<?php if (!empty($event['EventPrice'])):?>
				<h3><?php echo __('Valores');?></h3>
				<table class="table table-striped table-bordered table-condensed jsRowSelect">
				<tr>
					<th>&nbsp;</th>
					<th><?php echo __('Observação');?></th>
					<th><?php echo __('Valor'); ?></th>
					<th><?php echo __('Data inicial'); ?></th>
					<th><?php echo __('Data final'); ?></th>
				</tr>
				<?php foreach ($event['EventPrice'] as $eventPrice): ?>
					<tr>
						<td><?php echo "<input type=\"radio\" name=\"data[Subscription][event_price_id]\" value=\"{$eventPrice['id']}\" />"; ?></td>
						<td><?php echo $eventPrice['observation'];?></td>
						<td><?php echo $this->Locale->currency($eventPrice['price']);?></td>
						<td><?php echo $this->Locale->dateTime($eventPrice['start_date']);?></td>
						<td><?php echo $this->Locale->dateTime($eventPrice['final_date']);?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php endif; ?>
		</fieldset>
	<?php echo $this->Form->end(__('Confirmar'));?>
	</div>
</div>