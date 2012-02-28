<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Minhas Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Meus Pagamentos'), array('controller' => 'payments', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="events index">
<h2><?php echo __('Eventos');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registros de um total de %count% , começando em %start%, terminando em %end%')
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo __('Nome do Evento',1);?></th>
	<th><?php echo __('Gratuito?',1);?></th>
	<th><?php echo __('Inscritos',1);?></th>
	<th class="actions"><?php echo __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($events as $event):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $event['Event']['id']; ?>
		</td>
		<td>
			<?php echo $event['Event']['title']; ?>
		</td>
		<td>
			<?php echo $event['Event']['free']?__('Sim'):__('Não'); ?>
		</td>
		<td>
			<?php echo $event['Event']['subscription_count']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Visualizar'), array('action' => 'view', $event['Event']['id'])); ?>
			<?php echo $this->Html->link(__('Inscrever-se'), array('controller' => 'subscriptions' ,'action' => 'add', $event['Event']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('Página Anterior'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('Próxima Página').' >>', array(), null, array('class' => 'disabled'));?>
</div>
