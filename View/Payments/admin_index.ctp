<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Novo Pagamento'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Inscrição'), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments index">
<h2><?php echo __('Pagamentos');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% entradas de %count% total, començando na entrada %start%, terminando em %end%')
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort(__('Inscrição'), 'Payment.subscription_id');?></th>
	<th><?php echo $this->Paginator->sort(__('Data', TRUE), 'Payment.date');?></th>
	<th><?php echo __('Evento');?></th>
	<th><?php echo $this->Paginator->sort(__('Valor', TRUE), 'Payment.amount');?></th>
	<th><?php echo $this->Paginator->sort(__('Confirmado?', TRUE), 'Payment.confirmed');?></th>
	<th class="actions"><?php echo __('Ações',1);?></th>
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
			<?php echo $this->Html->link($payment['Subscription']['User']['fullName'], array('controller' => 'subscriptions', 'action' => 'view', $payment['Subscription']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Locale->date($payment['Payment']['date']); ?>
		</td>
		<td>
			<?php echo  $this->Html->link($payment['Subscription']['Event']['title'], array('controller' => 'events', 'action' => 'view', $payment['Subscription']['Event']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Locale->currency($payment['Payment']['amount']); ?>
		</td>
		<td>
			<?php echo ($payment['Payment']['confirmed'] ? __('Sim',1) : __('Não',1)); ?>
		</td>
		<td class="actions">
			<?php
			if($payment['Payment']['confirmed'] == 0)
				echo $this->Html->link(__('Confirmar', TRUE), array('action' => 'confirm', $payment['Payment']['id']), null, sprintf(__('Deseja realmente confirmar o pagamento da inscrição # %s?'), $payment['Subscription']['id']));
			?>
			<?php echo $this->Html->link(__('Visualizar'), array('action' => 'view', $payment['Payment']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $payment['Payment']['id'])); ?>
			<?php echo $this->Html->link(__('Apagar'), array('action' => 'delete', $payment['Payment']['id']), null, sprintf(__('Tem certeza que deseja apagar # %s?'), $payment['Payment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('anterior'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('próxima').' >>', array(), null, array('class' => 'disabled'));?>
</div>