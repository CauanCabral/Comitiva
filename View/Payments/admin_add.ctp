<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Pagamentos'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Inscrição'), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments form">
<?php echo $this->Form->create('Payment', array('action' => 'add'));?>
	<fieldset>
 		<legend><?php echo __('Informar Pagamento');?></legend>
		<h3>Evento: <?php echo $subscription['Event']['title']; ?></h3>
	<?php
		echo $this->Form->input('Payment.subscription_id', array('type' => 'hidden', 'value' => $subscription['Subscription']['id']));
		echo $this->Form->input('Payment.amount', array('label' => __('Valor')));
		echo $this->Form->input('Payment.date', array('type' => 'date', 'label' => 'Data', 'dateFormat' => 'DMY', 'minYear' => '2010', 'maxYear' => '2010'));
		echo $this->Form->input('Payment.information', array('label' => __('Informações'), 'type' => 'textarea'));
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