<div class="form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Criar uma conta');?></legend>
	<?php
		echo $form->input('name', array('label' => __('Nome', TRUE)));
		echo $form->input('nickname', array('label' => __('Sobrenome', TRUE)));
		echo $form->input('birthday', array('label' => __('Data de nascimento', TRUE)));
		echo $form->input('email', array('label' => __('Email', TRUE)));
		echo $form->input('username', array('label' => __('Nome de usuário', TRUE)));
		echo $form->input('password', array('label' => __('Senha', TRUE)));
		echo $form->input('password_confirm', array('label' => __('Re-digite a senha', TRUE)));
		
	?>
	</fieldset>
<?php echo $form->end(__('Criar', TRUE));?>
</div>