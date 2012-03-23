<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Minhas Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="payments index">
<h2><?php echo __('Meus Pagamentos');?></h2>
<table class="table table-striped table-bordered table-condensed">
<tr>
	<th><?php echo $this->Paginator->sort('Payment.date', __('Data'));?></th>
	<th><?php echo __('Evento');?></th>
	<th><?php echo $this->Paginator->sort('Payment.amount', __('Valor'));?></th>
	<th><?php echo $this->Paginator->sort('Payment.confirmed', __('Confirmado?'));?></th>
</tr>
<?php
$i = 0;
foreach ($payments as $payment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
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
</div>
<?php
echo $this->element('paginate');