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
		echo $form->input('name', array('label' => __('Nome', TRUE)));
		echo $form->input('nickname', array('label' => __('Sobrenome', TRUE)));
		echo $form->input('birthday', array('label' => __('Data de nascimento', TRUE)));
		echo $form->input('email', array('label' => __('Email', TRUE)));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>