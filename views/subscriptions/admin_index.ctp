<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions index">
<h2><?php __('Inscrições');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registros de %count% total, começando na entrada %start%, terminando em %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('ID',  TRUE), 'Subscription.id');?></th>
	<th><?php echo $paginator->sort(__('Usuário', TRUE), 'User.name');?></th>
	<th><?php echo $paginator->sort(__('Evento', TRUE), 'Event.title');?></th>
	<th><?php echo $paginator->sort(__('Data da inscrição', TRUE), 'Subscription.created');?></th>
	<th><?php __('Pagamento');?></th>
	<th><?php echo $paginator->sort(__('Check-in', TRUE), 'Subscription.checked');?></th>
	<th class="actions"><?php __('Ações');?></th>
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
			<?php echo $html->link($subscription['User']['name'], array('controller' => 'users', 'action' => 'view', $subscription['User']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Formatacao->data($subscription['Subscription']['created']); ?>
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
				if(!$subscription['Event']['free'] && isset($subscription['Payment']['id']) && !$subscription['Payment']['confirmed'])
					echo $html->link(__('Confirmar pagamento', TRUE), array('controller' => 'payments', 'action' => 'confirm', $subscription['Payment']['id']), null, sprintf(__('Deseja realmente confirmar o pagamento da inscrição # %s?', true), $subscription['Subscription']['id']));
				
				if(($subscription['Event']['free'] || $subscription['Payment']['confirmed']) && !$subscription['Subscription']['checked'])
					echo $html->link(__('Check-in', TRUE), array('controller' => 'subscriptions', 'action' => 'checkin', $subscription['Subscription']['id']));
			?>
			<?php echo $html->link(__('Ver', true), array('action' => 'view', $subscription['Subscription']['id'])); ?>
			<?php echo $html->link(__('Alterar', true), array('action' => 'edit', $subscription['Subscription']['id'])); ?>
			<?php echo $html->link(__('Remover', true), array('action' => 'delete', $subscription['Subscription']['id']), null, sprintf(__('Deseja realmente excluir # %s?', true), $subscription['Subscription']['id'])); ?>
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