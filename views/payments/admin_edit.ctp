<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Apagar', true), array('action' => 'delete', $form->value('Payment.id')), null, sprintf(__('Tem certeza que deseja apagar # %s?', true), $form->value('Payment.id'))); ?></li>
		<li><?php echo $html->link(__('Listar Pagamentos', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Inscrição', true), array('controller' => 'subscriptions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="payments form">
<?php echo $form->create('Payment');?>
	<fieldset>
 		<legend><?php __('Editar Pagamento');?></legend>
	<?php
		echo $form->input('subscription_id', array('label' => __('Inscrição' ,1)));
		echo $form->input('date', array('label' => __('Data' ,1)));
		echo $form->input('amount', array('label' => __('Quantia' ,1)));
		echo $form->input('information', array('label' => __('Informação' ,1)));
		echo $form->input('confirmed', array('label' => __('Confirmado?' ,1)));
	?>
	</fieldset>
<?php echo $form->end('Enviar');?>
</div>