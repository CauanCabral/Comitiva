<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Minhas Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Meus Pagamentos'), array('controller' => 'payments', 'action' => 'index')); ?> </li>
	</ul>
	<div class="span10">
		<h2><?php echo __('Eventos');?></h2>
		<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo $this->Paginator->sort('Event.title', __('Título'));?></th>
			<th><?php echo $this->Paginator->sort('Event.open', __('Aberto para inscrição?'));?></th>
			<th><?php echo $this->Paginator->sort('Event.free', __('Gratuito?'));?></th>
			<th><?php echo __('Inscritos');?></th>
			<th class="actions"><?php echo __('Ações');?></th>
		</tr>
		<?php
		foreach ($events as $event):
		?>
			<tr>
				<td>
					<?php echo $event['Event']['title']; ?>
				</td>
				<td>
					<?php echo $event['Event']['open']?__('Sim'):__('Não'); ?>
				</td>
				<td>
					<?php echo $event['Event']['free']?__('Sim'):__('Não'); ?>
				</td>
				<td>
					<?php echo $event['Event']['subscription_count']; ?>
				</td>
				<td class="actions">
					<?php
						echo $this->Html->glyphLink(__('Visualizar'), array('action' => 'view', $event['Event']['id']), array('glyph' => 'glyph-file glyph-large'));

						if($event['Event']['open'])
							echo $this->Html->glyphLink(__('Inscrever-se'), array('controller' => 'subscriptions' ,'action' => 'add', $event['Event']['id']), array('glyph' => 'glyph-signin glyph-large'));
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php echo $this->element('paginate'); ?>
	</div>
</div>