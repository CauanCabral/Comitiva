<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar usuários', TRUE), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Adicionar Usuário');?></legend>
	<?php
		echo $this->Form->input('name', array('label' => __('Nome', TRUE)));
		echo $this->Form->input('nickname', array('label' => __('Sobrenome', TRUE)));
		echo $this->Form->input('groups', array(
			'label' => __('Grupos', TRUE),
			'options' => array(
				'participant' => __('Participante',TRUE),
				'speaker' => __('Palestrante', TRUE),
				'admin' => __('Administrador', TRUE)
				),
			'multiple' => TRUE
			)
		);
		echo $this->Form->input('birthday', array(
			'label' => __('Data de nascimento', TRUE),
			'type' => 'date',
			'dateFormat' => 'DMY',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y')-10
			)
		);
		echo $this->Form->input('username', array('label' => __('Nome de usuário', TRUE)));
		echo $this->Form->input('password', array('label' => __('Senha', TRUE)));
		echo $this->Form->input('password_confirm', array('label' => __('Confirme a senha', TRUE), 'type' => 'password', 'div' => array('class' => 'required')));
		echo $this->Form->input('email', array('label' => __('Email', TRUE)));
		echo $this->Form->input('cpf', array('label' => __('CPF', 1)));
		echo $this->Form->input('address', array('label' => __('Endereço', 1)));
		echo $this->Form->input('city', array('label' => __('Cidade',1)));
		echo $this->Form->input('state', array('label' => __('Estado', 1)));
		echo $this->Form->input('phone', array('label' => 'Telefone',1));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar', TRUE));?>
</div>