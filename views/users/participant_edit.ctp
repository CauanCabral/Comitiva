<div class="users form">
<?php echo $form->create('User', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Editar Dados');?></legend>
	<?php
		echo $form->input('id', array('type'=>'hidden','value' => $this->data['User']['id']));
		echo $form->input('username', array(
			'label' => __('Nome de Usuário'),
			'disabled' => true
		));
		echo $form->input('password',array(
			'label' => __('Senha')	
		));
		echo $form->input('email');
		echo $form->input('User.name',array(
			'label' => __('Nome')
		));
		echo $form->input('nickname',array(
			'label' => __('Sobrenome')
		));
		echo $form->input('birthday',array(
			'label' => __('Nascimento'),
			'type' => 'date',
			'minYear' => '1910',
			'maxYear' => '2010',
			'dateFormat' => 'DMY'
		));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Minhas Inscrições', true), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
	</ul>
</div>