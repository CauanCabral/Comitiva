<?php echo $this->element('editor'); ?>
<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Eventos'), array('action' => 'index'));?></li>
	</ul>
	<div class="span10">
	<?php echo $this->Form->create('Event');?>
	<fieldset>
 		<legend><?php echo __('Novo Evento');?></legend>
		<?php
		echo $this->Form->newLine(array('5', '3'));
		echo $this->Form->input('Event.title', array('label' => __('Titulo'), 'class' => 'fullWidth'));
		echo $this->Form->input('Event.parent_id', array('label' => __('Macro Evento'), 'options' => array_merge(array('Selecione um evento'),$events)));

		echo $this->Form->inputBootstrap('Event.free', array('label' => __('Gratuito?'), 'type' => 'checkbox'));
		echo $this->Form->inputBootstrap('Event.open_for_proposals', array('type' => 'checkbox', 'label' => __('Aberto para Submissão de Propostas')));

		$this->Form->newLine(array('10'));
		echo $this->Form->input('Event.description', array('label' => __('Descrição'), 'rows' => 15));

		echo $this->Html->link(__('Adicionar preço'), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventPrice'));
		echo $this->Form->input('EventPrice.counter', array('type' => 'hidden', 'value' => 0, 'id' => 'priceCounter'));
		echo '<fieldset id="pricesEvent"></fieldset>';

		if(isset($this->request->data['EventPrice']) && !empty($this->request->data['EventPrice']))
		{
			$counter = 0;

			foreach($this->request->data['EventPrice'] as $i => $eventPrice)
			{
				echo $this->requestAction("/admin/events/eventPriceAdd/index:{$i}");
				$counter++;
			}

			$this->Html->scriptBlock('$("#priceCounter").val('. $counter .')', array('secure' => true));
		}

		/******
		 * EventDate hasMany add
		 */
		echo $this->Html->link(__('Adicionar data'), array('action' => 'eventPriceAdd', 'prefix' => 'admin'), array('id' => 'addEventDate'));
		echo $this->Form->input('EventDate.counter', array('type' => 'hidden', 'value' => 0, 'id' => 'dateCounter'));
		echo '<fieldset id="datesEvent"></fieldset>';

		// Recover error state
		if(isset($this->request->data['EventDate']) && !empty($this->request->data['EventDate']))
		{
			$counter = 0;

			foreach($this->request->data['EventDate'] as $i => $eventDate)
			{
				echo $this->requestAction("/admin/events/eventDateAdd/index:{$i}");
				$counter++;
			}

			$this->Html->scriptBlock('$("#dateCounter").val('. $counter .')', array('secure' => true));
		}
	?>
	</fieldset>
	<?php echo $this->Form->end(__('Salvar'));?>
	</div>
</div>
<?php echo $this->Html->script('events'); ?>