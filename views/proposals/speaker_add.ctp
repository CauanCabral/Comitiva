<div class="proposals form">
<?php echo $this->Form->create('Proposal');?>
	<fieldset>
 		<legend><?php __('Adicionar Proposta de Apresentação'); ?></legend>
	<?php
		echo $this->Form->input('event_id',
			array(
				'options' => array_merge(array(__('-- Selecione o Evento --', true)), $events), 
				'label' => 'Evento'
		));
		echo $this->Form->input('mini_curriculum', array('label' => __('Seu mini-currículo', TRUE), 'rows' => 7));
		echo $this->Form->input('area', array('label' => __('Palavras-chave', true)));
		echo $this->Form->input('abstract', array('label' => __('O resumo da sua apresentação',TRUE), 'rows' => 7));
		echo $this->Form->input('detailed', array('label' => __('Descrição detalhada (enumere os tópicos)',TRUE), 'rows' => 15));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submeter', true));?>
</div>
<div class="actions">
	<h3><?php __('Opções'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Página Inicial', true), '/');?></li>
		
	</ul>
</div>