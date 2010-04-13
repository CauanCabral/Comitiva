<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions form">
<?php
	echo $this->Form->create('Subscription', array('action' => 'add' . '/' . $event['Event']['id']));
	echo $this->Form->input('Subscription.confirm', array('type' => 'hidden', 'value' => sha1($event['Event']['id'])));
?>
	<fieldset>
 		<legend><?php __('Confirme sua Inscrição');?></legend>
		<h2><?php __('Nome do Evento') ?></h2>
		<?php
			echo '<h3>'.$event['Event']['title'].'</h3>'; 
		
			if(!empty($event['ParentEvent']['title'])):
		?>
		<br />
		<h2><?php __('Macro Evento') ?></h2>
		<h3><?php echo $event['ParentEvent']['title']; ?> </h3>
		<?php endif; ?>
		
		<?php if (!empty($event['EventDate'])):?>
		<br />
		<div class="related">
			<h3><?php __('Datas');?></h3>
			
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php __('Legenda'); ?></th>
				<th><?php __('Data'); ?></th>
			</tr>
			<?php
				$i = 0;
				foreach ($event['EventDate'] as $eventDate):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
				<tr<?php echo $class;?>>
					<td><?php echo $eventDate['desc'];?></td>
					<td><?php echo $this->Formatacao->dataHora($eventDate['date']);?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
		<?php endif; ?>
		
		<?php if (!empty($event['EventPrice'])):?>
		<br />
		<div class="related">
			<h3><?php __('Valores');?></h3>
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php __('Observação');?></th>
				<th><?php __('Valor'); ?></th>
				<th><?php __('Data inicial'); ?></th>
				<th><?php __('Data final'); ?></th>
			</tr>
			<?php
				$i = 0;
				foreach ($event['EventPrice'] as $eventPrice):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
				<tr<?php echo $class;?>>
					<td><?php echo $eventPrice['observation'];?></td>
					<td><?php echo $this->Formatacao->moeda($eventPrice['price']);?></td>
					<td><?php echo $this->Formatacao->dataHora($eventPrice['start_date']);?></td>
					<td><?php echo $this->Formatacao->dataHora($eventPrice['final_date']);?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
		<?php endif; ?>
	</fieldset>
<?php echo $form->end(__('Confirmar', TRUE));?>
</div>