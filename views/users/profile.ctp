<span><?php echo sprintf(__('Seja bem vindo %s', TRUE), $user['User']['name']); ?></span>
<h1><?php __('Meus dados');?></h1>
<hr />

<dl>
	<dt><?php echo __('Último acesso', TRUE), ':'; ?></dt>
	<dd><?php echo $user['User']['last_access'];?></dd>
</dl>