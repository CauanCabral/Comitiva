<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar usuários'), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Adicionar Usuário');?></legend>
	<?php
		echo $this->Form->input('name', array('label' => __('Nome')));
		echo $this->Form->input('nickname', array('label' => __('Sobrenome')));
		echo $this->Form->input('groups', array(
			'label' => __('Grupos'),
			'options' => array(
				'participant' => __('Participante'),
				'speaker' => __('Palestrante'),
				'admin' => __('Administrador')
				),
			'multiple' => TRUE
			)
		);
		echo $this->Form->input('birthday', array(
			'label' => __('Data de nascimento'),
			'type' => 'date',
			'dateFormat' => 'DMY',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y')-10
			)
		);
		echo $this->Form->input('username', array('label' => __('Nome de usuário')));
		echo $this->Form->input('password', array('label' => __('Senha')));
		echo $this->Form->input('password_confirm', array('label' => __('Confirme a senha'), 'type' => 'password', 'div' => array('class' => 'required')));
		echo $this->Form->input('email', array('label' => __('Email')));
		echo $this->Form->input('cpf', array('label' => __('CPF')));
		echo $this->Form->input('address', array('label' => __('Endereço')));
		echo $this->Form->input('city', array('label' => __('Cidade')));
		echo $this->Form->input('state', array('label' => __('Estado')));
		echo $this->Form->input('phone', array('label' => 'Telefone'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar', TRUE));?>
</div>