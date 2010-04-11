<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Novo Pagamento', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments index">
<h2><?php __('Pagamentos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% entradas de %count% total, començando na entrada %start%, terminando em %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('Inscrição'), 'Payment.subscription_id');?></th>
	<th><?php echo $paginator->sort(__('Data', TRUE), 'Payment.date');?></th>
	<th><?php echo __('Evento');?></th>
	<th><?php echo $paginator->sort(__('Valor', TRUE), 'Payment.amount');?></th>
	<th><?php echo $paginator->sort(__('Confirmado?', TRUE), 'Payment.confirmed');?></th>
	<th class="actions"><?php __('Ações',1);?></th>
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
			<?php echo $html->link($payment['Subscription']['User']['fullName'], array('controller' => 'subscriptions', 'action' => 'view', $payment['Subscription']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Formatacao->data($payment['Payment']['date']); ?>
		</td>
		<td>
			<?php echo  $this->Html->link($payment['Subscription']['Event']['title'], array('controller' => 'events', 'action' => 'view', $payment['Subscription']['Event']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Formatacao->moeda($payment['Payment']['amount']); ?>
		</td>
		<td>
			<?php echo ($payment['Payment']['confirmed'] ? __('Sim',1) : __('Não',1)); ?>
		</td>
		<td class="actions">
			<?php
			if($payment['Payment']['confirmed'] == 0)
				echo $html->link(__('Confirmar', TRUE), array('action' => 'confirm', $payment['Payment']['id']), null, sprintf(__('Deseja realmente confirmar o pagamento da inscrição # %s?', true), $payment['Subscription']['id']));
			?>
			<?php echo $html->link(__('Visualizar', true), array('action' => 'view', $payment['Payment']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action' => 'edit', $payment['Payment']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action' => 'delete', $payment['Payment']['id']), null, sprintf(__('Tem certeza que deseja apagar # %s?', true), $payment['Payment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('próxima', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>