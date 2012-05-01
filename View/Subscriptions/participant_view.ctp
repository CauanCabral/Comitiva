<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Informar pagamento'), array('controller' => 'payments', 'action' => 'add', $subscription['Subscription']['id']));  ?>
		<li><?php 

		if($subscription['Event']['free'])
			echo $this->Html->link(__('Cancelar Inscrição'), array('action' => 'delete', $subscription['Subscription']['id']), array(), __('Deseja cancelar a inscrição?')); ?> </li>
	</ul>
	<div class="span10">
	<h2><?php echo __('Inscrição');?></h2>
		<dl><?php $i = 0; $class = ' class="altrow"';?>

			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Evento'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Inscrito em '); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Locale->dateTime($subscription['Subscription']['created']); ?>
				&nbsp;
			</dd>
		</dl>
		<h3><?php echo __('Pagamentos Efetuados');?></h3>
		<?php if (!empty($subscription['Payment']['id'])):?>
		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<th><?php echo __('Data'); ?></th>
				<th><?php echo __('Valor'); ?></th>
				<th><?php echo __('Informções'); ?></th>
				<th><?php echo __('Confirmado'); ?></th>
				<th class="actions"><?php echo __('Ações');?></th>
			</tr>
			<tr>
				<td><?php echo $this->Locale->date($subscription['Payment']['date']);?></td>
				<td><?php echo $this->Locale->currency($subscription['Payment']['amount']);?></td>
				<td><?php echo $subscription['Payment']['information'];?></td>
				<td><?php echo $subscription['Payment']['confirmed'] ? __('Sim') : __('Não');?></td>

				<td class="actions">
					<?php echo $this->Html->glyphLink(__('Ver'), array('controller' => 'payments', 'action' => 'view', $subscription['Payment']['id']), array('glyph' => 'glyph-file glyph-large')); ?>
				</td>
			</tr>
		</table>
		<?php endif; ?>
	</div>
</div>