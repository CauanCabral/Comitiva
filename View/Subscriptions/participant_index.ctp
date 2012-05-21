<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Pagamentos Efetuados'), array('controller' => 'payments', 'action' => 'index')); ?> </li>
	</ul>
	<div class="span10">
		<h2><?php echo __('Inscrições');?></h2>
		<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo $this->Paginator->sort('event_id', __('Evento'));?></th>
			<th><?php echo __('Pagamento');?></th>
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
					<?php echo $this->Html->link($subscription['Event']['title'], array('controller' => 'subscriptions', 'action' => 'view', $subscription['Subscription']['id'])); ?>
				</td>
				<td>
					<?php
						if(isset($subscription['Payment']['amount']))
							echo $subscription['Payment']['confirmed'] ? __('Confirmado') : __('Em confirmação');
						else if($subscription['Event']['free'])
							echo __('Gratuito');
						else
							echo __('Não realizado');
					?>
				</td>
				<td class="actions">
					<?php
						echo $this->Html->link(__('Ver'), array('action' => 'view', $subscription['Subscription']['id']), array('glyph' => true, 'icon' => 'file large'));

						if($subscription['Event']['free'] === false && !isset($subscription['Payment']['id']))
							echo $this->Html->link(__('Informar pagamento'), array('controller' => 'payments', 'action' => 'add', $subscription['Subscription']['id']), array('glyph' => 'glyph-tag glyph-large'));
						if($subscription['Event']['free'])
							echo $this->Html->link(__('Remover'), array('action' => 'delete', $subscription['Subscription']['id']), array('glyph' => true, 'icon' => 'trash large'), sprintf(__('Deseja realmente excluir a inscrição #%s?'), $subscription['Subscription']['id']));
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php echo $this->element('paginate'); ?>
	</div>
</div>
