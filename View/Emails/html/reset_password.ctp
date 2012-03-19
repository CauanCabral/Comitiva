<?php
App::uses('Router', 'Routing');

$link = Router::url("/reset_password/{$token}", true);
?>
<p>
Olá <?php echo $user;?>,
<br />
Foi solicitado através de nosso sistema de inscrição em eventos a recuperação de sua senha.
<br />
Para dar prosseguimento a recuperação da senha, acesse o endereço: <a href="<?php echo $link; ?>"><?php echo $link; ?></a>.
<br />
Este link é válido por 24h.
<br />
Caso não tenha feito a solicitação, ignore a mensagem.
</p>