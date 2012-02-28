<div class="users form">
<?php echo $this->Form->create('User', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php echo __('Editar Dados');?></legend>
 		<p><?php echo __('Se desejar você pode alterar abaixo seu tipo de participação')?>
	<?php
		echo $this->Form->input('User.username', array(
			'label' => __('Nome de Usuário',1),
			'disabled' => true
		));
		echo $this->Form->input('User.email');
		echo $this->Form->input('User.name',array(
			'label' => __('Nome',1)
		));
		echo $this->Form->input('User.nickname',array(
			'label' => __('Sobrenome',1)
		));
		echo $this->Form->input('User.birthday',array(
			'label' => __('Nascimento',1),
			'type' => 'date',
			'minYear' => date('Y')-100,
			'maxYear' => date('Y'),
			'dateFormat' => 'DMY'
		));
		echo $this->Form->input('User.cpf', array('label' => __('CPF', 1)));
		echo $this->Form->input('User.address', array('label' => __('Endereço', 1)));
		echo $this->Form->input('User.city', array('label' => __('Cidade',1)));
		echo $this->Form->input('User.state', array('label' => __('Estado', 1)));
		echo $this->Form->input('User.phone', array('label' => 'Telefone',1));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar', 1));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Minhas Inscrições'), array('controller' => 'subscriptions', 'action' => 'index')); ?> </li>
	</ul>
</div>