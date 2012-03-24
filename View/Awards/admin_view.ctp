<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Visualizar Sorteio');?></h2>
		<dl>
			<dt><?php echo __('Título'); ?></dt>
			<dd>
				<?php echo $award['Award']['title']; ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Descrição'); ?></dt>
			<dd>
				<?php echo $award['Award']['description']; ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Criado em'); ?></dt>
			<dd>
				<?php echo $this->Locale->date($award['Award']['created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modificado em'); ?></dt>
			<dd>
				<?php echo $this->Locale->date($award['Award']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Ações'); ?></li>
			<li><?php echo $this->Html->link(__('Alterar sorteio'), array('action' => 'edit', $award['Award']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Excluir sorteio')), array('action' => 'delete', $award['Award']['id']), null, __('Deseja excluir o sorteio?')); ?> </li>
			<li><?php echo $this->Html->link(__('Listar sorteios'), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('Novo sorteio'), array('action' => 'add')); ?> </li>
		</ul>
	</div>
<div>

