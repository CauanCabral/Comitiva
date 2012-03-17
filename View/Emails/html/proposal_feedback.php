<?php
echo $approve ? 'Parabéns, ': 'Olá, ';


echo '<p>Sua proposta de apresentação no evento ',
	$proposal['Event']['title'];

if($approve)
	echo ' foi aprovada pela comissão organizadora do evento.',
		' Logo entraremos em contato para acertar os detalhes.<br /><br />';
else
	echo '  não foi aprovada. Agradecemos profundamente o seu interesse e esperamos sua proposta em eventos futuros.',
		' Caso haja alguma dúvida entre em contato com a equipe organizadora.<br/><br/>';

echo '</p>';

echo '<p>Atenciosamente,</p>',
	'<p>Equipe Organizadora</p>';