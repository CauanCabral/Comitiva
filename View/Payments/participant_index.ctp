<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Minhas Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
	<div class="span10">
	<h2><?php echo __('Meus Pagamentos');?></h2>
	<table class="table table-striped table-bordered table-condensed">
	<tr>
		<th><?php echo $this->Paginator->sort('Payment.date', __('Data'));?></th>
		<th><?php echo __('Evento');?></th>
		<th><?php echo $this->Paginator->sort('Payment.amount', __('Valor'));?></th>
		<th><?php echo $this->Paginator->sort('Payment.confirmed', __('Confirmado?'));?></th>
	</tr>
	<?php
	foreach ($payments as $payment):
	?>
		<tr>
			<td>
				<?php echo $this->Locale->date($payment['Payment']['date']); ?>
			</td>
			<td>
				<?php echo  $payment['Subscription']['Event']['title'] ?>
			</td>
			<td>
				<?php echo $this->Locale->currency($payment['Payment']['amount']); ?>
			</td>
			<td>
				<?php echo ($payment['Payment']['confirmed']?__('Sim'):__('Não')); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php echo $this->element('paginate'); ?>
	</div>
</div>