<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar usuários', TRUE), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Adicionar Usuário');?></legend>
	<?php
		echo $form->input('name', array('label' => __('Nome', TRUE)));
		echo $form->input('nickname', array('label' => __('Sobrenome', TRUE)));
		echo $form->input('type', array(
			'label' => __('Tipo', TRUE),
			'options' => array(
				'participant' => __('Participante',TRUE),
				'admin' => __('Administrador', TRUE)
				)
			)
		);
		echo $form->input('birthday', array('label' => __('Data de nascimento', TRUE)));
		echo $form->input('username', array('label' => __('Nome de usuário', TRUE)));
		echo $form->input('password', array('label' => __('Senha', TRUE)));
		echo $form->input('password_confirm', array('label' => __('Re-digite a senha', TRUE), 'type' => 'password'));
		echo $form->input('email', array('label' => __('Email', TRUE)));
		echo $form->input('cpf', array('label' => __('CPF', 1)));
		echo $form->input('address', array('label' => __('Endereço', 1)));
		echo $form->input('city', array('label' => __('Cidade',1)));
		echo $form->input('state', array('label' => __('Estado', 1)));
		echo $form->input('phone', array('label' => 'Telefone',1));
	?>
	</fieldset>
<?php echo $form->end(__('Enviar', TRUE));?>
</div>