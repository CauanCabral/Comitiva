<div class="users form">
<?php echo $form->create('User', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Editar Dados');?></legend>
 		<p><?php __('Se desejar você pode alterar abaixo seu tipo de participação')?>
	<?php
		echo $form->input('type', array(
			'label' => __('Tipo', TRUE),
			'options' => array(
				0 => '--Selecione--',
				'participant' => __('Participante',TRUE),
				'speaker' => __('Palestrante', TRUE)
				),
			'selected' => $this->data['User']['type']
			)
		);
		echo $form->input('username', array(
			'label' => __('Nome de Usuário',1),
			'disabled' => true
		));
		echo $form->input('email');
		echo $form->input('User.name',array(
			'label' => __('Nome',1)
		));
		echo $form->input('nickname',array(
			'label' => __('Sobrenome',1)
		));
		echo $form->input('birthday',array(
			'label' => __('Nascimento',1),
			'type' => 'date',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y'),
			'dateFormat' => 'DMY'
		));
		echo $form->input('cpf', array('label' => __('CPF', 1)));
		echo $form->input('address', array('label' => __('Endereço', 1)));
		echo $form->input('city', array('label' => __('Cidade',1)));
		echo $form->input('state', array('label' => __('Estado', 1)));
		echo $form->input('phone', array('label' => 'Telefone',1));
	?>
	</fieldset>
<?php echo $form->end('Salvar');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Minhas Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
	</ul>
</div>