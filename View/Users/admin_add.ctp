<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar usuários'), array('action' => 'index'));?></li>
	</ul>
	<div class="span10">
		<?php echo $this->Form->create('User');?>
		<fieldset>
	 		<legend><?php echo __('Adicionar Usuário');?></legend>
		<?php
			$this->Form->defineRow(array(4, 4, 4));
			echo $this->Form->input('name', array('label' => __('Nome'), 'class' => 'fullWidth'));
			echo $this->Form->input('nickname', array('label' => __('Sobrenome'), 'class' => 'fullWidth'));
			echo $this->Form->input('birthday', array(
				'label' => __('Data de nascimento'),
				'type' => 'text',
				'class' => 'jsDatepicker'
				)
			);

			$this->Form->useGride(false);
			echo $this->Form->input('groups', array(
				'label' => __('Grupos'),
				'options' => array(
					'participant' => __('Participante'),
					'speaker' => __('Palestrante'),
					'admin' => __('Administrador')
					),
				'multiple' => true
				)
			);

			$this->Form->defineRow(array(7, 3));
			echo $this->Form->input('email', array('label' => __('Email'), 'class' => 'fullWidth'));
			echo $this->Form->input('cpf', array('label' => __('CPF'), 'class' => 'fullWidth'));

			$this->Form->defineRow(array(4, 3, 1, 2));
			echo $this->Form->input('address', array('label' => __('Endereço'), 'class' => 'fullWidth'));
			echo $this->Form->input('city', array('label' => __('Cidade'), 'class' => 'fullWidth'));
			echo $this->Form->input('state', array('label' => __('Estado'), 'class' => 'fullWidth'));
			echo $this->Form->input('phone', array('label' => __('Telefone'), 'class' => 'fullWidth'));

			$this->Form->defineRow(array(4, 3, 3));
			echo $this->Form->input('username', array('label' => __('Nome de usuário'), 'class' => 'fullWidth'));
			echo $this->Form->input('password', array('label' => __('Senha'), 'class' => 'fullWidth'));
			echo $this->Form->input('password_confirm', array('label' => __('Confirme a senha'), 'type' => 'password', 'required' => true,'class' => 'fullWidth','div' => 'required'));
		?>
		</fieldset>
	<?php echo $this->Form->end(__('Enviar'));?>
	</div>
</div>