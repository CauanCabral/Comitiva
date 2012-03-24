<div class="row-fluid">
	<ul  class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Todos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo sorteio'), array('action' => 'new')); ?> </li>
	</ul>
	<div class="span10">
	<h2><?php  echo __('Premiação');?></h2>
		<dl>
			<dt><?php echo __('Premiação'); ?></dt>
			<dd>
				<?php echo h($raffle['Award']['title']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Ganhador'); ?></dt>
			<dd>
				<?php echo h($raffle['User']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Registrado em'); ?></dt>
			<dd>
				<?php echo h($raffle['Raffle']['created']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
</div>
