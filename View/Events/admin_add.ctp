<?php echo $this->element('editor'); ?>
<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('action' => 'index'));?></li>
	</ul>
	<div class="span10">
	<?php echo $this->Form->create('Event', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php echo __('Novo Evento');?></legend>
		<?php
		$this->Form->defineRow(array(5, 3));
		echo $this->Form->input('Event.title', array('label' => __('Titulo'), 'class' => 'fullWidth'));
		echo $this->Form->input('Event.parent_id', array('label' => __('Macro Evento'), 'options' => array_merge(array('Selecione um evento'),$events)));

		$this->Form->defineRow(array(10));
		echo $this->Form->input('Event.lead', array('label' => __('Resumo'), 'class' => 'fullWidth', 'rows' => 3));

		$this->Form->restoreDefaults();
		echo $this->Form->input('Event.free', array('label' => __('Gratuito?'), 'type' => 'checkbox'));
		echo $this->Form->input('Event.open_for_proposals', array('type' => 'checkbox', 'label' => __('Aberto para Submissão de Propostas')));

		$this->Form->defineRow(array(10));
		echo $this->Form->input('Event.description', array('label' => __('Descrição'), 'rows' => 15));

		echo $this->Html->link(__('Adicionar preço'), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventPrice'));
		echo '<fieldset id="pricesEvent"></fieldset>';

		$counter = 0;
		if(isset($this->request->data['EventPrice']) && !empty($this->request->data['EventPrice']))
		{

			foreach($this->request->data['EventPrice'] as $i => $eventPrice)
			{
				echo $this->requestAction("/admin/events/eventPriceAdd/index:{$i}");
				$counter++;
			}

			$this->Html->scriptBlock('$("#priceCounter").val('. $counter .')', array('secure' => true));
		}
		echo $this->Form->input('EventPrice.counter', array('type' => 'hidden', 'value' => $counter, 'id' => 'priceCounter'));

		echo $this->Html->link(__('Adicionar data'), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventDate'));
		echo '<fieldset id="datesEvent"></fieldset>';

		$counter = 0;
		if(isset($this->request->data['EventDate']) && !empty($this->request->data['EventDate']))
		{
			foreach($this->request->data['EventDate'] as $i => $eventDate)
			{
				echo $this->requestAction("/admin/events/eventDateAdd/index:{$i}");
				$counter++;
			}
		}

		echo $this->Form->input('EventDate.counter', array('type' => 'hidden', 'value' => $counter, 'id' => 'dateCounter'));

		echo $this->Form->input('EventDate.certified_dir', array('type' => 'hidden'));
		$this->Form->defineRow(array(4,4));
		echo $this->Form->input('EventDate.certified', array('type' => 'file', 'label' => 'Imagem do Certificado'));
		echo $this->Form->input('EventDate.position', array('label' => 'Posição do Nome do Participante (x,y)'));

		$this->Form->defineRow(array(8));
		echo $this->Form->input('EventDate.certified_description', array('label' => 'Texto do Certificado'));
	?>
	</fieldset>
	<?php echo $this->Form->end(__('Salvar'));?>
	</div>
</div>
<?php echo $this->Html->script('events'); ?>