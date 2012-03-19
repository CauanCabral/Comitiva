<p>
Olá <?php echo $approve ? 'Parabéns, ': 'Olá, ';?>,
<br />

<p>
Sua proposta de apresentação no evento<?php echo $proposal['Event']['title'];

if($approve)
	echo ' foi aprovada pela comissão organizadora do evento.',
		' Logo entraremos em contato para acertar os detalhes.';
else
	echo '  não foi aprovada. Agradecemos profundamente o seu interesse e esperamos sua proposta em eventos futuros.',
		' Caso haja alguma dúvida entre em contato com a equipe organizadora.';
?>
</p>

<br /><br />