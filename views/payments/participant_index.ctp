<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Minhas Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="payments index">
<h2><?php __('Meus Pagamentos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registros de um total de %count%, começando no registro %start%, terminando em %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('date');?></th>
	<th><?php echo __('Evento');?></th>
	<th><?php echo $paginator->sort('amount');?></th>
	<th><?php echo $paginator->sort('confirmed');?></th>

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
			<?php echo $payment['Payment']['id']; ?>
		</td>
	
		<td>
			<?php echo $payment['Payment']['date']; ?>
		</td>
		<td>
			<?php echo  $payment['Subscription']['Event']['title'] ?>
		</td>
		<td>
			<?php echo $payment['Payment']['amount']; ?>
		</td>
		<td>
			<?php echo ($payment['Payment']['confirmed']?__('Sim',1):__('Não',1)); ?>
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
