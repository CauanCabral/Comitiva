<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Minhas Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments form">
<?php echo $form->create('Payment', array('action' => 'add'));?>
	<fieldset>
 		<legend><?php __('Informar Pagamento');?></legend>
		<h3>Evento: <?php echo $subscription['Event']['title']; ?></h3>
		<p>
		Por favor, preencha corretamente os campos abaixo. Os dados serão confirmados
		pela organização do evento.
		</p>
		<br />
		<h4>Caso tenha optado pelo pagamento via MoIP, informe apenas o email utilizado no pagamento.</h4>
		<h4>Caso tenha optado pelo pagamento via transferência/depósito, informe a data e hora e número da operação
		para que possamos confirmar o pagamento e a inscrição.</h4>
	<?php
		echo $form->input('Subscription.id', array('type' => 'hidden', 'value' => $subscription['Subscription']['id']));
		echo $form->input('Payment.amount', array('label' => __('Valor',1)));
		echo $form->input('Payment.date', array('type' => 'date', 'label' => 'Data', 'dateFormat' => 'DMY', 'minYear' => '2010', 'maxYear' => '2010'));
		echo $form->input('Payment.information', array('label' => __('Informações',1), 'type' => 'textarea'));
	?>
	</fieldset>
<?php echo $form->end('Confirmar');?>
</div>