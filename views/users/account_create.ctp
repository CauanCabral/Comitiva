<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Início',1), '/') ?></li>
	</ul>
</div>
<div class="form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Criar uma conta');?></legend>
	<?php
		echo $form->input('name', array(
			'label' => __('Nome', TRUE),
			'error' => array(
				'notempty' => __('Informe seu nome',1)
			)	
		));
		echo $form->input('nickname', array('label' => __('Sobrenome', TRUE)));
		echo $form->input('birthday', array(
			'label' => __('Data de nascimento', TRUE),
			'type' => 'date',
			'dateFormat' => 'DMY',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y')-10
		));
		echo $form->input('email', array('label' => __('Email', TRUE),
			'error' => array(
				'notempty' => __('Informe seu e-mail',1),
				'email' => __('Informe um e-mail valido',1),
				'unique' => __('Este e-mail já está em uso',1)
			)	
		));
		echo $form->input('username', array(
			'label' => __('Nome de usuário', TRUE),
			'error' => array(
				'notempty' => __('Informe um nome de usuário',1),
				'unique' => __('Este nome de usuário já está em uso',1),
				'alphanumeric' => __('Forneça uma combinação de números e letras',1)
			)
		));
		echo $form->input('User.password', array('label' => __('Senha', TRUE)));
		echo $form->input('User.password_confirm', array(
			'label' => __('Confirme a senha', TRUE),
			'type' => 'password',
			'div' => array('class' => 'required')
		));
		echo $form->input('cpf', array('label' => __('CPF', 1)));
		echo $form->input('address', array('label' => __('Endereço', 1)));
		echo $form->input('city', array('label' => __('Cidade',1)));
		echo $form->input('state', array('label' => __('Estado', 1)));
		echo $form->input('phone', array('label' => 'Telefone',1));
		
		echo "<p class='small' style='color:red;'>* Informações obrigatórias para geração de certificado.</p>";
	?>
	</fieldset>
<?php echo $form->end(__('Criar', TRUE));?>
</div>