<?php
App::uses('Router', 'Routing');

$link = Router::url("/confirmar_conta/{$token}/{$user['username']}", true);
?>
<p>
Olá <?php echo $user['name'];?>,
<br />
Esta mensagem é uma confirmação da criação de sua conta no sistema de inscrição de eventos do PHPMS.
<br />
Você está registrado com o usuário <b><?php echo $user['username']; ?></b>.
<br />
Para confirmar a criação da conta, acesse o link: <a href="<?php echo $link; ?>"><?php echo $link ?></a>.
<br />
Este link é válido por 24h.
<br />
Caso não tenha feito o registro, apenas ignore a mensagem e a conta será removida.
</p>