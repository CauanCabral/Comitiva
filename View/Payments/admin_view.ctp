<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Confirmar pagamento', TRUE), array('controller' => 'payments', 'action' => 'confirm', $payment['Payment']['id']), null, sprintf(__('Deseja realmente confirmar o pagamento da inscrição # %s?'), $payment['Payment']['id'])); ?></li>
		<li><?php echo $this->Html->link(__('Editar Pagamento'), array('action' => 'edit', $payment['Payment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Apagar Pagamento'), array('action' => 'delete', $payment['Payment']['id']), null, sprintf(__('Tem certeza que deseja apagar # %s?'), $payment['Payment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Pagamentos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Inscrição'), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments view">
<h2><?php echo __('Pagamento',1);?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payment['Payment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Inscrição'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($payment['Subscription']['id'], array('controller' => 'subscriptions', 'action' => 'view', $payment['Subscription']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->data($payment['Payment']['date']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Valor'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->moeda($payment['Payment']['amount']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Informações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payment['Payment']['information']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Confirmado?'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo ($payment['Payment']['confirmed']?__('Sim'):__('Não')); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Criado em '); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->data($payment['Payment']['created']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modificado em '); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->data($payment['Payment']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
