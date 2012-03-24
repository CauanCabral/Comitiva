<div class="row-fluid">
	<ul  class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Alterar Premiação'), array('action' => 'edit', $award['Award']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Excluir Premiação'), array('action' => 'delete', $award['Award']['id']), null, __('Deseja excluir a premiação?')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Premiações'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Premiação'), array('action' => 'add')); ?> </li>
	</ul>
	<div class="span10">
		<h2><?php  echo __('Visualizar premiação');?></h2>
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
		<h2><?php  echo __('Ganhadores');?></h2>
		<dl>
		<?php 
			foreach($award['Raffle'] as $raffle):
		?>
		<dt><?php echo __('Participante'); ?></dt>
			<dd>
				<?php echo $raffle['User']['name']; ?>
				&nbsp;
			</dd>
		<?php endforeach; ?>
		</dl>
	</div>
<div>

