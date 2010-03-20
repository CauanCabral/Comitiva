<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Eventos', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('Inscrever neste evento', true), array('controller' => 'subscriptions', 'action' => 'add',$event['Event']['id'])); ?> </li>
	</ul>
</div>
<div class="events view">
<h2><?php  __('Evento');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Inscritos'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['subscription_count']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Descrição'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Macro Evento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($event['ParentEvent']['title'], array('controller' => 'events', 'action' => 'view', $event['ParentEvent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gratuito'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['free'] == TRUE ? __('Sim') : __('Não'); ?>
			&nbsp;
		</dd>
	</dl>
	
	<div class="related">
		<h3><?php __('Pagamento')?></h3>
		<p>Você pode realizar o pagamento de sua inscrição pelo serviço MoIP.<br/>
		   Basta clicar no botão abaixo e seguir os passos pedidos. Após realizar o pagamento, vá até<br />
		   a página de suas inscrições e confirme o pagamento informando o email utilizado.
		</p>
		<form method='post' action='https://www.moip.com.br/PagamentoSimples.do' class="moip">
			<input type='hidden' name='id_carteira' value='cauan'/>
			<input type='hidden' name='valor' value='2000'/>
			<input type='hidden' name='nome' value='Inscrição no 3º Workshop PHPMS'/>
			<input type='hidden' name='descricao' value='Valor válido para pagamentos realizados até 24/03/2010.'/>
			<input type='image' name='submit' src='https://www.moip.com.br/imgs/buttons/bt_pagar_c01_e01.png' alt='Pagar' border='0' />
		</form>
		<br />
		<p>
			Se preferir, você ainda pode fazer uma transferência, DOC ou depósito para a conta:
		</p>
		<dl>
			<dt>Banco</dt>
			<dd>Bradesco</dd>
			<dt class="altrow">Agência</dt>
			<dd class="altrow">3585-0</dd>
			<dt>Conta Poupança</dt>
			<dd>1000103-0</dd>
			<dt class="altrow">Titular</dt>
			<dd class="altrow">Cauan Gama Cabral</dd>
			<dt>CPF do Titular</dt>
			<dd>019.155.051-51</dd>
		</dl>
		<p>
			<strong>ATENÇÃO: a Conta é Poupança. Depósito/transferência para conta Corrente será desconsiderado.</strong>
			Não se esqueça de confirmar seu pagamento, informando o valor, data e horário do depósito ou transferência, caso tenha optado por este método.
		</p>
	</div>
	
	
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
			<th><?php __('Observação');?></th>
			<th><?php __('Valor'); ?></th>
			<th><?php __('Período'); ?></th>
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
				<td><?php echo $eventPrice['observation'];?></td>
				<td><?php echo $this->Formatacao->moeda($eventPrice['price']);?></td>
				<td><?php echo __('entre'), ' ', $this->Formatacao->data($eventPrice['start_date']), ' ', __('e', TRUE), ' ',$this->Formatacao->data($eventPrice['final_date']);?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
	<?php endif; ?>
	
	<?php if (!empty($event['ChildEvent'])):?>
	<br />
	<div class="related">
		<h3><?php __('Sub-eventos');?></h3>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php __('Nome'); ?></th>
			<th><?php __('Descrição'); ?></th>
			<th><?php __('Gratuito'); ?></th>
			<th class="actions"><?php __('Ações');?></th>
		</tr>
		<?php
			$i = 0;
			foreach ($event['ChildEvent'] as $childEvent):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td><?php echo $childEvent['title'];?></td>
				<td><?php echo $childEvent['description'];?></td>
				<td><?php $childEvent['free'] == TRUE ? __('Sim') : __('Não');?></td>
				<td class="actions">
					<?php echo $html->link(__('Inscrever-se', true), array('controller' => 'subscriptions', 'action' => 'add', $childEvent['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
	<?php endif; ?>
</div>