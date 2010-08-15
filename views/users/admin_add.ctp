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
		echo $form->input('groups', array(
			'label' => __('Grupos', TRUE),
			'options' => array(
				'participant' => __('Participante',TRUE),
				'speaker' => __('Palestrante', TRUE),
				'admin' => __('Administrador', TRUE)
				),
			'multiple' => TRUE
			)
		);
		echo $form->input('birthday', array(
			'label' => __('Data de nascimento', TRUE),
			'type' => 'date',
			'dateFormat' => 'DMY',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y')-10
			)
		);
		echo $form->input('username', array('label' => __('Nome de usuário', TRUE)));
		echo $form->input('password', array('label' => __('Senha', TRUE)));
		echo $form->input('password_confirm', array('label' => __('Confirme a senha', TRUE), 'type' => 'password', 'div' => array('class' => 'required')));
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