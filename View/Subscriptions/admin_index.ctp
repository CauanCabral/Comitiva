<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Nova Inscrição'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Gerar lista de inscritos'), array('action' => 'getCsv', $event_id)); ?></li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions index">
<h2><?php echo __('Inscrições');?></h2>
<table class="table table-striped table-bordered table-condensed">
<tr>
	<th><?php echo $this->Paginator->sort('Subscription.id', __('ID'));?></th>
	<th><?php echo $this->Paginator->sort('User.fullName', __('Usuário'));?></th>
	<th><?php echo $this->Paginator->sort('Event.title', __('Evento'));?></th>
	<th><?php echo $this->Paginator->sort('Subscription.created', __('Data da inscrição'));?></th>
	<th><?php echo __('Pagamento');?></th>
	<th><?php echo $this->Paginator->sort('Subscription.checked', __('Check-in'));?></th>
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
					echo $this->Html->link(__('Informar pagamento'), array('controller' => 'payments', 'action' => 'add', $subscription['Subscription']['id']));

				if(!$subscription['Event']['free'] && isset($subscription['Payment']['id']) && !$subscription['Payment']['confirmed'])
					echo $this->Html->link(__('Confirmar pagamento'), array('controller' => 'payments', 'action' => 'confirm', $subscription['Payment']['id']), null, sprintf(__('Deseja realmente confirmar o pagamento da inscrição # %s?'), $subscription['Subscription']['id']));

				if(($subscription['Event']['free'] || $subscription['Payment']['confirmed']) && !$subscription['Subscription']['checked'])
					echo $this->Html->link(__('Check-in'), array('controller' => 'subscriptions', 'action' => 'checkin', $subscription['Subscription']['id']));
			?>
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $subscription['Subscription']['id'])); ?>
			<?php echo $this->Html->link(__('Alterar'), array('action' => 'edit', $subscription['Subscription']['id'])); ?>
			<?php echo $this->Html->link(__('Remover'), array('action' => 'delete', $subscription['Subscription']['id']), null, sprintf(__('Deseja realmente excluir # %s?'), $subscription['Subscription']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php
echo $this->element('paginate');