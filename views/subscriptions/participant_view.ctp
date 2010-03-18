<div class="subscriptions view">
<h2><?php  __('Inscrição');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Evento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($subscription['Event']['title'], array('controller' => 'events', 'action' => 'view', $subscription['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Inscrito em '); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $subscription['Subscription']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		
		<li><?php echo $html->link(__('Listar Inscrições', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Informar pagamento', true), array('controller' => 'payments', 'action' => 'add', $subscription['Subscription']['id'])); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Pagamentos Efetuados');?></h3>
	<?php if (!empty($subscription['Payment']['id'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Data'); ?></th>
		<th><?php __('Valor'); ?></th>
		<th><?php __('Informções'); ?></th>
		<th><?php __('Confirmado'); ?></th>
		<th class="actions"><?php __('Ações');?></th>
	</tr>
		<tr>
			<td><?php echo $this->Formatacao->data($subscription['Payment']['date']);?></td>
			<td><?php echo $this->Formatacao->moeda($subscription['Payment']['amount']);?></td>
			<td><?php echo $subscription['Payment']['information'];?></td>
			<td><?php $subscription['Payment']['confirmed'] ? __('Sim') : __('Não');?></td>

			<td class="actions">
				<?php echo $html->link(__('Visualizar', true), array('controller' => 'payments', 'action' => 'view', $subscription['Payment']['id'])); ?>
			</td>
		</tr>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			
		</ul>
	</div>
</div>
