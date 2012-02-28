<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Nova Inscrição'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Gerar lista de inscritos'), array('action' => 'getCsv', $event_id)); ?></li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
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
	<th><?php echo $this->Paginator->sort(__('ID',  TRUE), 'Subscription.id');?></th>
	<th><?php echo $this->Paginator->sort(__('Usuário', TRUE), 'User.fullName');?></th>
	<th><?php echo $this->Paginator->sort(__('Evento', TRUE), 'Event.title');?></th>
	<th><?php echo $this->Paginator->sort(__('Data da inscrição', TRUE), 'Subscription.created');?></th>
	<th><?php echo __('Pagamento');?></th>
	<th><?php echo $this->Paginator->sort(__('Check-in', TRUE), 'Subscription.checked');?></th>
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
			<?php echo $this->Html->link($subscription['User']['fullName'], array('controller' => 'users', 'action' => 'view', $subscription['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Locale->date($subscription['Subscription']['created']); ?>
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
		<td>
			<?php $subscription['Subscription']['checked'] ? __('Realizado') : __('Pendente');?>
		</td>
		<td class="actions">
			<?php
				if(!$subscription['Event']['free'] && !isset($subscription['Payment']['id']))
					echo $this->Html->link(__('Informar pagamento', TRUE), array('controller' => 'payments', 'action' => 'add', $subscription['Subscription']['id']));
					
				if(!$subscription['Event']['free'] && isset($subscription['Payment']['id']) && !$subscription['Payment']['confirmed'])
					echo $this->Html->link(__('Confirmar pagamento', TRUE), array('controller' => 'payments', 'action' => 'confirm', $subscription['Payment']['id']), null, sprintf(__('Deseja realmente confirmar o pagamento da inscrição # %s?'), $subscription['Subscription']['id']));
				
				if(($subscription['Event']['free'] || $subscription['Payment']['confirmed']) && !$subscription['Subscription']['checked'])
					echo $this->Html->link(__('Check-in', TRUE), array('controller' => 'subscriptions', 'action' => 'checkin', $subscription['Subscription']['id']));
			?>
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $subscription['Subscription']['id'])); ?>
			<?php echo $this->Html->link(__('Alterar'), array('action' => 'edit', $subscription['Subscription']['id'])); ?>
			<?php echo $this->Html->link(__('Remover'), array('action' => 'delete', $subscription['Subscription']['id']), null, sprintf(__('Deseja realmente excluir # %s?'), $subscription['Subscription']['id'])); ?>
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