<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar Meus Dados', true), array('controller' => 'users', 'action' => 'edit',$user['User']['id'])); ?> </li>
	</ul>
</div>
<span><?php echo sprintf(__('Seja bem vindo %s', TRUE), $user['User']['name']); ?></span>
<h1><?php __('Meus dados');?></h1>
<hr />

<dl>
	<dt><?php echo __('Último acesso', TRUE), ':'; ?></dt>
	<dd><?php echo $user['User']['last_access'];?></dd>
</dl>