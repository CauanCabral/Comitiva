<div class="payments view">
<h2><?php  __('Pagamento');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payment['Payment']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantia'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payment['Payment']['amount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Informações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payment['Payment']['information']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Confirmed'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo ($payment['Payment']['confirmed']?__('Sim',1):__('Não')); ?>
			&nbsp;
		</dd>
	
	</dl>
</div>
<div class="actions">
	<ul>
			<li><?php echo $html->link(__('List Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events')); ?> </li>
	</ul>
</div>
