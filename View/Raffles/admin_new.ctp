<div class="raffles form">
<?php echo $this->Form->create('Raffle', array('id' => 'jsForm'));?>
	<fieldset>
		<legend><?php echo __('Sorteio'); ?></legend>
		<?php
			echo $this->Form->input('award_id', array(
				'label' => __('Selecione o sorteio'),
				'id' => 'jsAward'
			));
			echo $this->Form->input('reincident', array(
				'label' => __('Reincidente'),
				'id' => 'jsReincident',
				'type' => 'checkbox'
			));
			echo $this->Form->hidden('user_id', array(
				'id' => 'jsUserId'
			));
			echo $this->Form->submit(__('Salvar ganhador'), array('id' => 'jsSubmit'));
		?>
		<div id="raffle"> 
			<fieldset>
				<legend><?php echo __('Iniciar') ?> </legend>
				<?php echo $this->Html->link(__('Iniciar'), '#', array('class' => 'btn btn-primary', 'id' => 'jsStartRaffle')); ?>
				<div id="winner" style="font-size: 1.9em;"></div>
			</fieldset>
		</div>
	</fieldset>
</div>
<?php
$script = <<<SCRIPT
	$('#jsStartRaffle').click(function() {
		repeat = $('#jsReincident').val();

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
