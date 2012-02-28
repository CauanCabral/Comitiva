<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Pagamentos Efetuados'), array('controller' => 'payments', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions index">
<h2><?php echo __('Inscrições');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registros de %count% total, começando na entrada %start%, terminando em %end%')
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort(__('Evento', TRUE), 'event_id');?></th>
	<th><?php echo __('Pagamento', TRUE);?></th>
	<th class="actions"><?php echo __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($subscriptions as $subscription):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $subscription['Subscription']['id']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($subscription['Event']['title'], array('controller' => 'subscriptions', 'action' => 'view', $subscription['Subscription']['id'])); ?>
		</td>
		<td>
			<?php
				if(isset($subscription['Payment']['amount']))
					$subscription['Payment']['confirmed'] ? __('Confirmado') : __('Em confirmação');
				else if($subscription['Event']['free'])
					__('Gratuito');
				else
					__('Não realizado');
			?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $subscription['Subscription']['id'])); ?>
			<?php
				if($subscription['Event']['free'] == 0 && !isset($subscription['Payment']['id']))
					echo $this->Html->link(__('Informar Pagamento'), array('controller' => 'payments', 'action' => 'add', $subscription['Subscription']['id']));
			?>
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
