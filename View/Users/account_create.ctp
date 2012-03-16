<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Início'), '/') ?></li>
	</ul>
</div>
<div class="form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Criar uma conta');?></legend>
	<?php
		echo $this->Form->input('name', array(
			'label' => __('Nome'),
			'error' => array(
				'notempty' => __('Informe seu nome')
			)	
		));
		echo $this->Form->input('nickname', array('label' => __('Sobrenome')));
		echo $this->Form->input('birthday', array(
			'label' => __('Data de nascimento'),
			'type' => 'date',
			'dateFormat' => 'DMY',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y')-10
		));
		echo $this->Form->input('email', array('label' => __('Email'),
			'error' => array(
				'notempty' => __('Informe seu e-mail',1),
				'email' => __('Informe um e-mail valido',1),
				'unique' => __('Este e-mail já está em uso',1)
			)	
		));
		echo $this->Form->input('username', array(
			'label' => __('Nome de usuário'),
			'error' => array(
				'notempty' => __('Informe um nome de usuário'),
				'unique' => __('Este nome de usuário já está em uso'),
				'alphanumeric' => __('Forneça uma combinação de números e letras')
			)
		));
		echo $this->Form->input('User.password', array('label' => __('Senha')));
		echo $this->Form->input('User.password_confirm', array(
			'label' => __('Confirme a senha'),
			'type' => 'password',
			'div' => array('class' => 'required')
		));
		echo $this->Form->input('cpf', array('label' => __('CPF')));
		echo $this->Form->input('address', array('label' => __('Endereço')));
		echo $this->Form->input('city', array('label' => __('Cidade')));
		echo $this->Form->input('state', array('label' => __('Estado')));
		echo $this->Form->input('phone', array('label' => 'Telefone'));
		
		echo "<p class='small' style='color:red;'>* Informações obrigatórias para geração de certificado.</p>";
	?>
	</fieldset>
<?php echo $this->Form->end(__('Criar'));?>
</div>