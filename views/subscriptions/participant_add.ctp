<div class="subscriptions form">

<?php echo $form->create('Subscription', array('action' => 'add'));?>
<?php ?>
	<fieldset>
 		<legend><?php __('Confirme sua Inscrição');?></legend>
	<h1><?php __('Nome do Evento') ?></h1>
		<?php
		 	echo $form->input('Event.id', array('type' => 'hidden', 'value' => $event['Event']['id']));
			echo '<h3>'.$event['Event']['title'].'</h3>'; 
		?>
		<h1><?php __('Data do Evento') ?></h1>
		<h3><?php echo @$event['EventDate']['date']; ?> </h3>
		<h1><?php __('Valor do Evento') ?></h1>
		<h3><?php echo @$event['EventPrice']['price']; ?> </h3>
		<h1><?php __('Macro Evento') ?></h1>
		<h3><?php echo $event['ParentEvent']['title']; ?> </h3>
	
	
	</fieldset>
<?php echo $form->end('Confirmar');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Subscriptions', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index')); ?> </li>

	</ul>
</div>
