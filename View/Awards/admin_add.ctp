<?php echo $this->element('editor'); ?>
<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Premiações'), array('action' => 'index'));?></li>
	</ul>
	<div class="span10">
		<?php echo $this->Form->create('Award');?>
			<fieldset>
				<legend><?php echo __('Novo Sorteio'); ?></legend>
				<?php
				$this->Form->defineRow(array(5, 3));
				echo $this->Form->input('title', array(
					'required' => 'required',
					'label' => __('Título'),
					'class' => 'fullWidth'
				));
				echo $this->Form->input('event_id', array(
					'label' => __('Evento')
				));
				$this->Form->useGrid(false);
				echo $this->Form->input('groups', array(
					'label' => __('Grupos'),
					'options' => array(
						'participant' => __('Participante'),
						'speaker' => __('Palestrante'),
						'admin' => __('Administrador')
						),
					'multiple' => true
					)
				);
				$this->Form->defineRow(array(10));
				echo $this->Form->input('description', array(
					'label' => __('Descrição'),
					'rows' => 15
				));
				?>
			</fieldset>
			<br />
			<?php echo $this->Form->submit(__('Salvar'));?>
	</div>
</div>
