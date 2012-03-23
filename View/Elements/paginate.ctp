<div class="row-fluid">
	<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => __('Página %page% de %pages%, mostrando %current% registros de %count%, começando no registro %start% e terminando no %end%')
			));
		?>
	</p>

	<div class="pagination">
		<?php
		echo $this->Paginator->prev('<< '.__('Página Anterior'), array(), null, array('class'=>'disabled')),
			$this->Paginator->numbers(),
			$this->Paginator->next(__('Próxima Página').' >>', array(), null, array('class' => 'disabled'));
		?>
	</div>
</div>