<div class="actions">
	<ul>
		
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Informar pagamento'), array('controller' => 'payments', 'action' => 'add', $subscription['Subscription']['id'])); ?> </li>
	</ul>
</div>
<div class="subscriptions view">
<h2><?php echo __('Inscrição');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Evento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Inscrito em '); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->data($subscription['Subscription']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php echo __('Pagamentos Efetuados');?></h3>
	<?php if (!empty($subscription['Payment']['id'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('Valor'); ?></th>
		<th><?php echo __('Informções'); ?></th>
		<th><?php echo __('Confirmado'); ?></th>
		<th class="actions"><?php echo __('Ações');?></th>
	</tr>
		<tr>
			<td><?php echo $this->Formatacao->data($subscription['Payment']['date']);?></td>
			<td><?php echo $this->Formatacao->moeda($subscription['Payment']['amount']);?></td>
			<td><?php echo $subscription['Payment']['information'];?></td>
			<td><?php $subscription['Payment']['confirmed'] ? __('Sim') : __('Não');?></td>

			<td class="actions">
				<?php echo $this->Html->link(__('Visualizar'), array('controller' => 'payments', 'action' => 'view', $subscription['Payment']['id'])); ?>
			</td>
		</tr>
	</table>
<?php endif; ?>

</div>
