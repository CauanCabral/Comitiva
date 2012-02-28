<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Apagar'), array('action' => 'delete', $this->Form->value('Payment.id')), null, sprintf(__('Tem certeza que deseja apagar # %s?'), $this->Form->value('Payment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Pagamentos'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Listar Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Inscrição'), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments form">
<?php echo $this->Form->create('Payment', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php echo __('Informar Pagamento');?></legend>
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
		echo $this->Form->input('Payment.id', array('type' => 'hidden', 'value' => $subscription['Payment']['id']));
		
		echo $this->Form->input('Payment.amount', array('label' => __('Valor',1)));
		echo $this->Form->input('Payment.date', array('type' => 'date', 'label' => 'Data', 'dateFormat' => 'DMY', 'minYear' => '2010', 'maxYear' => '2010'));
		echo $this->Form->input('Payment.information', array('label' => __('Informações',1), 'type' => 'textarea'));
		echo $this->Form->input('Payment.confirmed', array(
			'label' => __('Confirmado? ',1), 'options' => array(
				0 => __('Não', TRUE),
				1 => __('Sim', TRUE)
				)
			)
		);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Confirmar', TRUE));?>
</div>