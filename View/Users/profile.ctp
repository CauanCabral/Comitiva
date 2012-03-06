<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Editar Meus Dados'), array('controller' => 'users', 'action' => 'edit',$activeUser['id'])); ?> </li>
	</ul>
</div>
<span><?php echo sprintf(__('Seja bem vindo %s'), $activeUser['name']); ?></span>
<h1><?php echo __('Meus dados');?></h1>
<hr />

<dl>
	<dt><?php echo __('Último acesso'), ':'; ?></dt>
	<dd><?php echo $activeUser['last_access'];?></dd>
</dl>