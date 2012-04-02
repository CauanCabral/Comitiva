<div id="search">
	<?php
	echo $this->Form->create(
		Inflector::singularize($this->name),
		array(
			'url' => array_merge(array('controller' => $this->request->controller , 'action' => 'index'), $this->params['pass'])
		)
	);

	echo $this->Form->input('query', array(
		'label' => false,
		'class' => 'search search-query input-large',
		'div' => false,
		'placeholder' => 'Pesquisar'
		)
	);
	echo $this->Form->end();
	?>
	</div>
</div>