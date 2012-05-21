<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Nova Proposta'), array('action' => 'add')); ?></li>
	</ul>
	<div class="span10">
		<h2><?php echo __('Propostas');?></h2>
		<?php
		echo $this->Form->create('Proposal', array('id' => 'jsFilter'));
		echo $this->Form->input('Proposal.approved', array(
			'label' => __('Filtrar'),
			'id' => 'jsApproved',
			'options' => array(
					-1 => __('Selecione um filtro'),
					0 => __('Reprovados'),
					1 => __('Aprovados'),
				)
			)
		);
		echo $this->Form->end();
		?>
		<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><?php echo __('Proponente');?></th>
			<th><?php echo __('Evento');?></th>
			<th><?php echo __('Avaliação');?></th>
			<th><?php echo __('Aprovada?');?></th>
			<th><?php echo __('Recebida em');?></th>
			<th class="actions"><?php echo __('Ações');?></th>
		</tr>
		<?php
		foreach ($proposals as $proposal):
		?>
		<tr>
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
		if($proposal['Proposal']['approved'] === null)
		{
			echo $this->Html->link(__('Rejeitar'), array('action' => 'approve', $proposal['Proposal']['id'], false), array('glyph' => true, 'icon' => 'thumbs-down large'), sprintf(__('Deseja realmente rejeitar a proposta?')));
			echo $this->Html->link(__('Aprovar'), array('action' => 'approve', $proposal['Proposal']['id'], true), array('glyph' => true, 'icon' => 'thumbs-up large'), sprintf(__('Aprovar a proposta?')));
		}

		echo $this->Html->link(__('Visualizar'), array('action' => 'view', $proposal['Proposal']['id']), array('glyph' => true, 'icon' => 'file large')),
			$this->Html->link(__('Editar'), array('action' => 'edit', $proposal['Proposal']['id']), array('glyph' => true, 'icon' => 'edit large')),
			$this->Html->link(__('Excluir'), array('action' => 'delete', $proposal['Proposal']['id']), array('glyph' => true, 'icon' => 'trash large'), sprintf(__('Deseja realmente excluir a proposta #%s?'), $proposal['Proposal']['id']));
		?>
		</td>
		</tr>
	<?php endforeach; ?>
		</table>
		<?php echo $this->element('paginate'); ?>
	</div>
</div>
<?php
$script = <<<SCRIPT
$(document).ready(function() {
	console.log('aaa');
	$('#jsApproved').change(function() {
		console.log('bbb');
		$('#jsFilter').submit();
		return true;
	});
});
SCRIPT;

echo $this->Html->scriptBlock($script);