<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar usuários'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Remover'), array('action' => 'delete', $this->Form->value('User.id')), null, sprintf(__('Deseja realmente excluir # %s?'), $this->Form->value('User.id'))); ?></li>
	</ul>
</div>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Alterar usuário');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('User.active', array(
			'label' => __('Ativo'),
			'type' => 'checkbox',
		));
		echo $this->Form->input('name', array('label' => __('Nome')));
		echo $this->Form->input('nickname', array('label' => __('Sobrenome')));
		echo $this->Form->input('User.groups', array(
			'label' => __('Grupos'),
			'options' => array(
				'participant' => __('Participante'),
				'speaker' => __('Palestrante'),
				'admin' => __('Administrador')
			),
			'multiple' => TRUE
		));
		echo $this->Form->input('birthday', array(
			'label' => __('Data de nascimento'),
			'type' => 'date',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y')
		));
		echo $this->Form->input('email', array('label' => __('Email')));
		echo $this->Form->input('cpf', array('label' => __('CPF')));
		echo $this->Form->input('address', array('label' => __('Endereço')));
		echo $this->Form->input('city', array('label' => __('Cidade')));
		echo $this->Form->input('state', array('label' => __('Estado')));
		echo $this->Form->input('phone', array('label' => __('Telefone')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar'));?>
</div>