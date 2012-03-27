<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Minhas Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
	<div class="span10">
		<?php echo $this->Form->create('Payment', array('action' => 'add'));?>
		<fieldset>
	 		<legend><?php echo __('Informar Pagamento');?></legend>
			<h3>Evento: <?php echo $subscription['Event']['title']; ?></h3>
			<p><?php echo Configure::read('Comitiva.paymentInfo'); ?></p>
			<br />
		<?php
			echo $this->Form->input('Subscription.id', array('type' => 'hidden', 'value' => $subscription['Subscription']['id']));
			$this->Form->newLine(array('3', '3'));
			echo $this->Form->input('Payment.amount', array('label' => __('Valor')));
			echo $this->Form->input('Payment.date', array(
				'label' => __('Data'),
				'type' => 'text',
				'class' => 'jsDatepicker'
				));
			$this->Form->newLine(array('6'));
			echo $this->Form->input('Payment.information', array('label' => __('Informações'), 'type' => 'textarea', 'rows' => 15, 'class' => 'fullWidth'));
		?>
		</fieldset>
		<?php echo $this->Form->end('Confirmar');?>
	</div>
</div>