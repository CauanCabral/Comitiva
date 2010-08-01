<div class="proposals index">
	<h2><?php __('Propostas');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
      <th><?php __('Proponente');?></th>
      <th><?php __('Evento');?></th>
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
      <?php echo $proposal['User']['name']; ?>
    </td>
    <td>
      <?php echo $proposal['Event']['title']; ?>
    </td>
    <td>
      <?php echo $proposal['Proposal']['created']; ?>
    </td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $proposal['Proposal']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $proposal['Proposal']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $proposal['Proposal']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $proposal['Proposal']['id'])); ?>
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
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nova Proposta', true), array('action' => 'add')); ?></li>
	</ul>
</div>