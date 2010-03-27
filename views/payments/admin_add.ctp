<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Pagamentos', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments form">
<?php echo $form->create('Payment', array('action' => 'add'));?>
	<fieldset>
 		<legend><?php __('Informar Pagamento');?></legend>
		<h3>Evento: <?php echo $subscription['Event']['title']; ?></h3>
	<?php
		echo $form->input('Payment.subscription_id', array('type' => 'hidden', 'value' => $subscription['Subscription']['id']));
		echo $form->input('Payment.amount', array('label' => __('Valor',1)));
		echo $form->input('Payment.date', array('type' => 'date', 'label' => 'Data', 'dateFormat' => 'DMY', 'minYear' => '2010', 'maxYear' => '2010'));
		echo $form->input('Payment.information', array('label' => __('Informações',1), 'type' => 'textarea'));
		echo $form->input('Payment.confirmed', array(
			'label' => __('Confirmado? ',1), 'options' => array(
				0 => __('Não', TRUE),
				1 => __('Sim', TRUE)
				)
			)
		);
	?>
	</fieldset>
<?php echo $form->end('Confirmar');?>
</div>