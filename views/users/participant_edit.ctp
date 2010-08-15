<div class="users form">
<?php echo $form->create('User', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Editar Dados');?></legend>
 		<p><?php __('Se desejar você pode alterar abaixo seu tipo de participação')?>
	<?php
		echo $form->input('User.username', array(
			'label' => __('Nome de Usuário',1),
			'disabled' => true
		));
		echo $form->input('User.email');
		echo $form->input('User.name',array(
			'label' => __('Nome',1)
		));
		echo $form->input('User.nickname',array(
			'label' => __('Sobrenome',1)
		));
		echo $form->input('User.birthday',array(
			'label' => __('Nascimento',1),
			'type' => 'date',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y'),
			'dateFormat' => 'DMY'
		));
		echo $form->input('User.cpf', array('label' => __('CPF', 1)));
		echo $form->input('User.address', array('label' => __('Endereço', 1)));
		echo $form->input('User.city', array('label' => __('Cidade',1)));
		echo $form->input('User.state', array('label' => __('Estado', 1)));
		echo $form->input('User.phone', array('label' => 'Telefone',1));
	?>
	</fieldset>
<?php echo $form->end(__('Salvar', 1));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Minhas Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
	</ul>
</div>