<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Pagamentos'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Inscrição'), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
	<div class="span10">
	<?php echo $this->Form->create('Payment', array('action' => 'add'));?>
	<fieldset>
 		<legend><?php echo __('Informar Pagamento');?></legend>
		<h3>Evento: <?php echo $subscription['Event']['title']; ?></h3>
		<?php
		echo $this->Form->input('Payment.subscription_id', array('type' => 'hidden', 'value' => $subscription['Subscription']['id']));
		$this->Form->defineRow(array(3, 3));
		echo $this->Form->input('Payment.amount', array(
			'label' => __('Valor'),
			'value' => $this->Locale->number($subscription['Payment']['amount'])
			)
		);
		echo $this->Form->input('Payment.date', array(
			'label' => __('Data'),
			'type' => 'text',
			'class' => 'jsDatepicker'
			)
		);
		$this->Form->defineRow(array(6));
		echo $this->Form->input('Payment.information', array(
			'label' => __('Informações'),
			'type' => 'textarea',
			'rows' => 15,
			'class' => 'fullWidth')
		);
		$this->From->useGride(false);
		echo $this->Form->input('Payment.confirmed', array(
			'label' => __('Confirmado? '), 'options' => array(
				0 => __('Não'),
				1 => __('Sim')
				)
			)
		);
		?>
	</fieldset>
	<?php echo $this->Form->end('Confirmar');?>
	</div>
</div>