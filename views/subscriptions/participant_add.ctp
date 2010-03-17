<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Inscrições', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Listar Eventos', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="subscriptions form">
<?php echo $form->create('Subscription', array('action' => 'add'));?>
<?php ?>
	<fieldset>
 		<legend><?php __('Confirme sua Inscrição');?></legend>
		<h1><?php __('Nome do Evento') ?></h1>
		<?php
		 	echo $form->input('Subscription.event_id', array('type' => 'hidden', 'value' => $event['Event']['id']));
			echo '<h3>'.$event['Event']['title'].'</h3>'; 
		?>
		<h2><?php __('Macro Evento') ?></h2>
		<h3><?php echo $event['ParentEvent']['title']; ?> </h3>
		
		<?php if (!empty($event['EventDate'])):?>
		<br />
		<div class="related">
			<h3><?php __('Datas');?></h3>
			
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php __('Legenda'); ?></th>
				<th><?php __('Data'); ?></th>
			</tr>
			<?php
				$i = 0;
				foreach ($event['EventDate'] as $eventDate):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
				<tr<?php echo $class;?>>
					<td><?php echo $eventDate['desc'];?></td>
					<td><?php echo $this->Formatacao->dataHora($eventDate['date']);?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
		<?php endif; ?>
		
		<?php if (!empty($event['EventPrice'])):?>
		<br />
		<div class="related">
			<h3><?php __('Valores');?></h3>
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php __('Valor'); ?></th>
				<th><?php __('Data inicial'); ?></th>
				<th><?php __('Data final'); ?></th>
			</tr>
			<?php
				$i = 0;
				foreach ($event['EventPrice'] as $eventPrice):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
				<tr<?php echo $class;?>>
					<td><?php echo $this->Formatacao->moeda($eventPrice['price']);?></td>
					<td><?php echo $this->Formatacao->dataHora($eventPrice['start_date']);?></td>
					<td><?php echo $this->Formatacao->dataHora($eventPrice['final_date']);?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
		<?php endif; ?>
	</fieldset>
	
	<h2><?php __('Formas de pagamento')?></h2>
	<fieldset>
		Você pode efetuar a inscrição pagamento utilizando o MoIP:
			<form method='post' action='https://www.moip.com.br/PagamentoSimples.do'>
			<input type='hidden' name='id_carteira' value='cauan'/>
			<input type='hidden' name='valor' value='2000'/>
			<input type='hidden' name='nome' value='Inscrição no 3º Workshop PHPMS'/>
			<input type='hidden' name='descricao' value='Valor válido para pagamentos realizados até 24/03/2010.'/>
			<input type='image' name='submit' src='https://www.moip.com.br/imgs/buttons/bt_pagar_c01_e01.png' alt='Pagar' border='0' />
			</form>
		<br />
		Os seguintes meios de pagamento são aceitos: Cartão de débito, Boleto Bancário, Transferência Bancária e Transferência entre contas MoIP.
		<img src="http://www.moip.com.br/imgs/banner_3_1.gif" border="0">
	</fieldset>
<?php echo $form->end('Confirmar');?>
</div>