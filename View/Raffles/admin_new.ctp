<div class="row-fluid">
	<ul class="nav nav-tabs nav-stacked span2">
		<li><?php echo $this->Html->link(__('Listar Premiados'), array('action' => 'index'));?></li>
	</ul>
	<div class="span9">
		<?php echo $this->Form->create('Raffle', array('id' => 'jsForm'));?>
		<fieldset>
			<legend><?php echo __('Sorteio'); ?></legend>
			<?php
				echo $this->Form->input('award_id', array(
					'label' => __('Selecione a Premiação'),
					'id' => 'jsAward',
					'class' => 'fullWidth',

				));
				echo $this->Form->input('reincident', array(
					'label' => __('Reincidente? (Participante pode ser sorteado novamente?)'),
					'id' => 'jsReincident',
					'type' => 'checkbox',
					'class' => 'fullWidth'
				));
				echo $this->Form->hidden('user_id', array(
					'id' => 'jsUserId'
				));
			?>
				<div id="winner"  class="span4" style="font-size: 1.9em;float:right"></div>
			<?php echo $this->Html->link(__('Sortear'), '#', array('class' => 'btn btn-primary', 'id' => 'jsStartRaffle'));
				echo $this->Form->submit(__('Salvar ganhador'), array('id' => 'jsSubmit'));
			?>
		</fieldset>
	</div>
</div>
<?php
$script = <<<SCRIPT
	$('#jsStartRaffle').click(function() {
		repeat = $('#jsReincident').is(':checked') ? 1 : 0;

		$.ajax({
	  		url: '/admin/raffles/ajaxGetWinner',
	  		dataType: 'json',
	  		data: {reincident: repeat}
		})
		.success(function(data, status) { 
			$('#winner').html(data.name);
			$('#jsUserId').val(data.id);
		});
	});

	$('#jsSubmit').click(function(e) {
		e.preventDefault();

		award_id = $('#jsAward').val();

		if(award_id == 0)
		{
			alert("Selecione uma premiação antes");
		}
		else
		{
			$('#jsForm').submit();
		}
	});
SCRIPT;
echo $this->Html->scriptBlock($script);
