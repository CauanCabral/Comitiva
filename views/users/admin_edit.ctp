<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar usuários', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Remover', true), array('action' => 'delete', $form->value('User.id')), null, sprintf(__('Deseja realmente excluir # %s?', true), $form->value('User.id'))); ?></li>
	</ul>
</div>
<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Alterar usuário');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('User.active', array(
			'label' => __('Ativo', 1),
			'type' => 'checkbox',
		));
		echo $form->input('name', array('label' => __('Nome', TRUE)));
		echo $form->input('nickname', array('label' => __('Sobrenome', TRUE)));
		echo $form->input('User.groups', array(
			'label' => __('Grupos', TRUE),
			'options' => array(
				'participant' => __('Participante',TRUE),
				'speaker' => __('Palestrante', TRUE),
				'admin' => __('Administrador', TRUE)
			),
			'multiple' => TRUE
		));
		echo $form->input('birthday', array(
			'label' => __('Data de nascimento', TRUE),
			'type' => 'date',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y')
		));
		echo $form->input('email', array('label' => __('Email', TRUE)));
		echo $form->input('cpf', array('label' => __('CPF', 1)));
		echo $form->input('address', array('label' => __('Endereço', 1)));
		echo $form->input('city', array('label' => __('Cidade',1)));
		echo $form->input('state', array('label' => __('Estado', 1)));
		echo $form->input('phone', array('label' => __('Telefone',1)));
	?>
	</fieldset>
<?php echo $form->end(__('Salvar', TRUE));?>
</div>