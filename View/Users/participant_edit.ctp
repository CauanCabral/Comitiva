<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Minhas Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
	</ul>
	<div class="span10">
	<?php echo $this->Form->create('User', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php echo __('Editar Dados');?></legend>
	<?php
		echo $this->Form->input('User.id', array('type' => 'hidden'));
		echo $this->Form->inputBootstrap('User.username', array(
			'label' => __('Nome de Usuário'),
			'disabled' => true
		));
		$this->Form->newLine(array('3', '4', '3'));
		echo $this->Form->input('name', array('label' => __('Nome'), 'class' => 'fullWidth'));
		echo $this->Form->input('nickname', array('label' => __('Sobrenome'), 'class' => 'fullWidth'));
		echo $this->Form->input('birthday', array(
			'label' => __('Data de nascimento'),
			'type' => 'text',
			'class' => 'jsDatepicker fullWidth'
			)
		);
		$this->Form->newLine(array('7', '3'));
			echo $this->Form->input('email', array('label' => __('Email'), 'class' => 'fullWidth'));
			echo $this->Form->input('cpf', array('label' => __('CPF'), 'class' => 'fullWidth'));

			$this->Form->newLine(array('4', '3', '1', '2'));
			echo $this->Form->input('address', array('label' => __('Endereço'), 'class' => 'fullWidth'));
			echo $this->Form->input('city', array('label' => __('Cidade'), 'class' => 'fullWidth'));
			echo $this->Form->input('state', array('label' => __('Estado'), 'class' => 'fullWidth'));
			echo $this->Form->input('phone', array('label' => __('Telefone'), 'class' => 'fullWidth'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar', 1));?>
	</div>
</div>