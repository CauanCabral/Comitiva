<div class="proposals index">
	<h2><?php __('Propostas');?></h2>
	
	<form action="/admin/proposals/index" name="filter" method="post" >
		<select name="data[Proposal][approved]" onchange="this.form.submit()">
			<option value="-1"> <?php __('Filtrar')?> </option>
			<option value=0 ><?php echo __('Reprovados')?></option>
			<option value=1 ><?php echo __('Aprovados')?></option>
		</select>
	</form>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('Proponente');?></th>
		<th><?php __('Evento');?></th>
		<th><?php __('Avaliação');?></th>
		<th><?php __('Aprovada?');?></th>
		<th><?php __('Recebida em');?></th>
		<th class="actions"><?php __('Ações');?></th>
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
		<?php echo $html->link($proposal['User']['name'], array('controller' => 'users', 'action' => 'view', $proposal['User']['id'])); ?>
	</td>
	<td>
		<?php echo $proposal['Event']['title']; ?>
	</td>
	<td>
		<?php 
		switch($proposal['Proposal']['rating'])
		{
			case 1:
				echo '<p style="color:#DF0101;font-weight:bold">', __('Péssimo',1),'</p>';
			break;
			case 2:
				echo '<p style="color:#FE9A2E;font-weight:bold">',__('Ruim',1);
			break;
			case 3:
				echo '<p style="color:#AEB404;font-weight:bold">',__('Bom',1);
			break;
			case 4:
				echo '<p style="color:#045FB4;font-weight:bold">',__('Ótimo',1);
			break;
			case 5:
				echo '<p style="color:#04B404;font-weight:bold">',__('Excelente',1);
			break;
			default:
				echo __('Sem avaliação',1);
			break;
		}
    ?>
    </td>
    <td>
    	<?php echo $proposal['Proposal']['approved'] ? __('Sim',1) : __('Não',1); ?>
    </td>
    <td>
    	<?php echo $this->Locale->dateTime($proposal['Proposal']['created']); ?>
    </td>
	<td class="actions">
	<?php  
	if($proposal['Proposal']['approved'])
	{
		echo '  ',$html->link(__('Rejeitar',1), array('action' => 'approve', $proposal['Proposal']['id'], 0), null, sprintf(__('Rejeitar a proposta?', true)));
	}
	else
	{
		echo '  ',$html->link(__('Aprovar',1), array('action' => 'approve', $proposal['Proposal']['id'], 1), null, sprintf(__('Aprovar a proposta?', true)));
	}
	?>
		<?php echo $this->Html->link(__('Visualizar', true), array('action' => 'view', $proposal['Proposal']['id'])); ?>
		<?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $proposal['Proposal']['id'])); ?>
		<?php echo $this->Html->link(__('Apagar', true), array('action' => 'delete', $proposal['Proposal']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $proposal['Proposal']['id'])); ?>
	</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nova Proposta', true), array('action' => 'add')); ?></li>
	</ul>
</div>