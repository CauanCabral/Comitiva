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
			'minYear' => '1910',
			'maxYear' => '2010'
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
		echo $form->input('password', array('label' => __('Senha', TRUE)));
		echo $form->input('password_confirm', array(
		'label' => __('Re-digite a senha', TRUE),
		'type' => 'password'
		));
		
	?>
	</fieldset>
<?php echo $form->end(__('Criar', TRUE));?>

</div>
<div class="actions">
	<ul>
		<li></li>
	</ul>
</div>