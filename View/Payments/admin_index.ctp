<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Inscrição'), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
	<div class="span10">
		<h2><?php echo __('Pagamentos');?></h2>
		<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo $this->Paginator->sort('Payment.subscription_id', __('Inscrição'));?></th>
			<th><?php echo $this->Paginator->sort('Payment.date', __('Data'));?></th>
			<th><?php echo __('Evento');?></th>
			<th><?php echo $this->Paginator->sort('Payment.amount', __('Valor'));?></th>
			<th><?php echo $this->Paginator->sort('Payment.confirmed', __('Confirmado?'));?></th>
			<th class="actions"><?php echo __('Ações',1);?></th>
		</tr>
		<?php
		foreach ($payments as $payment):
		?>
			<tr>
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
					<?php echo $payment['Payment']['confirmed'] ? __('Sim') : __('Não'); ?>
				</td>
				<td class="actions">
					<?php
					if($payment['Payment']['confirmed'] == 0)
						echo $this->Html->link(__('Confirmar'), array('action' => 'confirm', $payment['Payment']['id']), array('glyph' => 'glyph-edit glyph-ok'), sprintf(__('Deseja realmente confirmar o pagamento da inscrição #%s?'), $payment['Subscription']['id']));

					echo $this->Html->glyphLink(__('Visualizar'), array('action' => 'view', $payment['Payment']['id']), array('glyph' => 'glyph-file glyph-large')),
						$this->Html->glyphLink(__('Editar'), array('action' => 'edit', $payment['Payment']['id']), array('glyph' => 'glyph-edit glyph-large')),
						$this->Html->glyphLink(__('Apagar'), array('action' => 'delete', $payment['Payment']['id']), array('glyph' => 'glyph-trash glyph-large'), sprintf(__('Tem certeza que deseja excluir o pagamento #%s?'), $payment['Payment']['id']));
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php echo $this->element('paginate'); ?>
	</div>
</div>
