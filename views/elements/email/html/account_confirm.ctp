<p>
Olá <?php echo $user['name'];?>,
<br />
Esta mensagem é uma confirmação da criação de sua conta no sistema de inscrição de eventos do PHPMS.
<br />
Você está registrado com o usuário <b><?php echo $user['username']; ?></b>.
<br />
Para confirmar a criação da conta, acesse o link: <a href="http://comitiva.phpms.org/account_confirm/<?php echo $token.'/'.$user['username']; ?>">http://comitiva.phpms.org/account_confirm/<?php echo $token.'/'.$user['username']; ?></a>.
<br />
Este link é válido por 24h.
<br />
Caso não tenha feito o registro, apenas ignore a mensagem e a conta será removida.
</p>

<p>
Atenciosamente,

PHPMS - Grupo de Desenvolvedores PHP de Mato Grosso do Sul
</p>