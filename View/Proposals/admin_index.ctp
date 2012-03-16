<div class="proposals index">
	<h2><?php echo __('Propostas');?></h2>
	
	<form action="/admin/proposals/index" name="filter" method="post" >
		<select name="data[Proposal][approved]" onchange="this.form.submit()">
			<option value="-1"> <?php echo __('Filtrar')?> </option>
			<option value=0 ><?php echo __('Reprovados')?></option>
			<option value=1 ><?php echo __('Aprovados')?></option>
		</select>
	</form>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo __('Proponente');?></th>
		<th><?php echo __('Evento');?></th>
		<th><?php echo __('Avaliação');?></th>
		<th><?php echo __('Aprovada?');?></th>
		<th><?php echo __('Recebida em');?></th>
		<th class="actions"><?php echo __('Ações');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($proposals as $proposal):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
	<td>
		<?php echo $this->Html->link($proposal['User']['name'], array('controller' => 'users', 'action' => 'view', $proposal['User']['id'])); ?>
	</td>
	<td>
		<?php echo $proposal['Event']['title']; ?>
	</td>
	<td>
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
				echo __('Sem avaliação');
			break;
		}
    ?>
    </td>
    <td>
    	<?php echo $proposal['Proposal']['approved'] ? __('Sim') : __('Não'); ?>
    </td>
    <td>
    	<?php echo $this->Locale->dateTime($proposal['Proposal']['created']); ?>
    </td>
	<td class="actions">
	<?php  
	if($proposal['Proposal']['approved'])
	{
		echo '  ',$this->Html->link(__('Rejeitar'), array('action' => 'approve', $proposal['Proposal']['id'], 0), null, sprintf(__('Rejeitar a proposta?')));
	}
	else
	{
		echo '  ',$this->Html->link(__('Aprovar'), array('action' => 'approve', $proposal['Proposal']['id'], 1), null, sprintf(__('Aprovar a proposta?')));
	}
	?>
		<?php echo $this->Html->link(__('Visualizar'), array('action' => 'view', $proposal['Proposal']['id'])); ?>
		<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $proposal['Proposal']['id'])); ?>
		<?php echo $this->Html->link(__('Apagar'), array('action' => 'delete', $proposal['Proposal']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $proposal['Proposal']['id'])); ?>
	</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nova Proposta'), array('action' => 'add')); ?></li>
	</ul>
</div>