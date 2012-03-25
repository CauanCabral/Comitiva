<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'events')); ?> </li>
	</ul>
	<div class="span10">
		<h2><?php echo __('Pagamento');?></h2>
		<dl><?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Data'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Locale->date($payment['Payment']['date']); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Valor'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Locale->currency($payment['Payment']['amount']); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Informações'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $payment['Payment']['information']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Confirmado'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo ($payment['Payment']['confirmed']?__('Sim'):__('Não')); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
</div>