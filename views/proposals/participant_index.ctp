<div class="proposals index">
	<h2><?php __('Envio de Propostas');?></h2>
	<?php  if(!isset($proposals)) { ?>
	<p><?php echo __('Clique em Nova Proposta para enviar uma nova proposta de apresentação. Após enviada ela será avaliada pelos organizadores do evento')?></p>
	<?php } else {?>
	<table cellpadding="0" cellspacing="0">
	<tr>
      <th><?php __('Proponente');?></th>
      <th><?php __('Evento');?></th>
      <th><?php __('Recebida em');?></th>
			<th class="actions"><?php __('Actions');?></th>
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
      <?php echo $proposal['Proposal']['created']; ?>
    </td>
		<td class="actions">
			<?php echo $this->Html->link(__('Visualizar', true), array('action' => 'view', $proposal['Proposal']['id'])); ?>
			<?php echo $this->Html->link(__('Editar', true), array('action' => 'edit', $proposal['Proposal']['id'])); ?>
			<?php echo $this->Html->link(__('Apagar', true), array('action' => 'delete', $proposal['Proposal']['id']), null, sprintf(__('Tem certeza que deseja excluir # %s?', true), $proposal['Proposal']['id'])); ?>
		</td>
	</tr>
<?php endforeach;  ?>
	</table>
	<?php  }?>
</div>
<div class="actions">
	<h3><?php __('Opções'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nova Proposta', true), array('action' => 'add')); ?></li>
	
	</ul>
</div>