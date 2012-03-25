<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Editar Meus Dados'), array('controller' => 'users', 'action' => 'edit', $activeUser['id'])); ?> </li>
	</ul>
	<div class="span10">
		<span><?php echo sprintf(__('Seja bem vindo %s'), $activeUser['name']); ?></span>
		<hr />

		<dl>
			<dt><?php echo __('Seu último acesso foi em'), ':'; ?></dt>
			<dd><?php echo $this->Locale->dateTime($activeUser['last_access']);?></dd>
		</dl>
	</div>
</div>