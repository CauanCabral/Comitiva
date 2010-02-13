<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar usuários', TRUE), array('action' => 'index'));?></li>
	</ul>
</div>
<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Adicionar Usuário');?></legend>
	<?php
		echo $form->input('name', array('label' => __('Nome', TRUE)));
		echo $form->input('nickname', array('label' => __('Sobrenome', TRUE)));
		echo $form->input('birthday', array('label' => __('Data de nascimento', TRUE)));
		
		echo $form->input('username', array('label' => __('Nome de usuário', TRUE)));
		echo $form->input('password', array('label' => __('Senha', TRUE)));
		echo $form->input('password_confirm', array('label' => __('Re-digite a senha', TRUE)));
		echo $form->input('email', array('label' => __('Email', TRUE)));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>