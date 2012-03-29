<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Editar Proposta'), array('action' => 'edit', $proposal['Proposal']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Apagar Proposta'), array('action' => 'delete', $proposal['Proposal']['id']), null, sprintf(__('Deseja deletar a proposta?'))); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Propostas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Avaliar Proposta'), array('action' => 'rating', $proposal['Proposal']['id'])); ?></li>
	</ul>
	<div class="span10">
	<h2><?php echo __('Proposta');?></h2>
		<dl><?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Html->link($proposal['User']['name'], array('controller' => 'users', 'action' => 'view', $proposal['User']['id'])); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Evento'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Html->link($proposal['Event']['title'], array('controller' => 'events', 'action' => 'view', $proposal['Event']['id'])); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Mini Curriculum'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $proposal['Proposal']['mini_curriculum']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Área'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $proposal['Proposal']['area']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Resumo'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $proposal['Proposal']['abstract']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Detalhes'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $proposal['Proposal']['detailed']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Avaliação'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php

					switch($proposal['Proposal']['rating'])
					{
						case 1:
							echo '<p style="color:#DF0101;font-weight:bold">', __('Péssimo'),'</p>';
						break;
						case 2:
							echo '<p style="color:#FE9A2E;font-weight:bold">',__('Ruim');
						break;
						case 3:
							echo '<p style="color:#AEB404;font-weight:bold">',__('Bom');
						break;
						case 4:
							echo '<p style="color:#045FB4;font-weight:bold">',__('Ótimo');
						break;
						case 5:
							echo '<p style="color:#04B404;font-weight:bold">',__('Excelente');
						break;
						default:
							echo __('Essa proposta ainda não foi avaliada. ').$this->Html->link(__('Avaliar'), array('action' => 'rating', $proposal['Proposal']['id']));
						break;
					}
				?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Aprovado'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $proposal['Proposal']['approved'] ? __('Sim') : __('Não'); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Criado em'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Locale->dateTime($proposal['Proposal']['created']); ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modificado em'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->Locale->dateTime($proposal['Proposal']['modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
</div>