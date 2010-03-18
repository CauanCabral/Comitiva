<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar Pagamento', true), array('action' => 'edit', $payment['Payment']['id'])); ?> </li>
		<li><?php echo $html->link(__('Apagar Pagamento', true), array('action' => 'delete', $payment['Payment']['id']), null, sprintf(__('Tem certeza que deseja apagar # %s?', true), $payment['Payment']['id'])); ?> </li>
		<li><?php echo $html->link(__('Listar Pagamentos', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments view">
<h2><?php  __('Pagamento',1);?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payment['Payment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Inscrição'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($payment['Subscription']['id'], array('controller' => 'subscriptions', 'action' => 'view', $payment['Subscription']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->data($payment['Payment']['date']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Valor'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->moeda($payment['Payment']['amount']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Informações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payment['Payment']['information']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Confirmado?'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo ($payment['Payment']['confirmed']?__('Sim'):__('Não')); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Criado em '); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->data($payment['Payment']['created']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modificado em '); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Formatacao->data($payment['Payment']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
