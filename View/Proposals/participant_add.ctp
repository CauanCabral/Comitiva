<?php echo $this->element('editor'); ?>
<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Página Inicial'), '/');?></li>
	</ul>
	<div class="span10">
	<div class="proposals form">
<?php echo $this->Form->create('Proposal'); ?>
	<fieldset>
 		<legend><?php echo __('Adicionar Proposta de Apresentação'); ?></legend>
	<?php
		//echo $this->Form->input('event_id',array('type' => 'hidden', 'value' => $event_id));
		echo $this->Form->input('event_id',
			array(
				'options' => $events, 
				'label' => 'Evento',
				'selected' => $event_id
		));
		echo $this->Form->input('mini_curriculum', array('label' => __('Seu mini-currículo'), 'rows' => 8));
		echo $this->Form->input('area', array('label' => __('Palavras-chave')));
		echo $this->Form->input('abstract', array('label' => __('O resumo da sua apresentação'), 'rows' => 8));
		echo $this->Form->input('detailed', array('label' => __('Descrição detalhada (enumere os tópicos)'), 'rows' => 15));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar'));?>
</div>
</div>
</div>

