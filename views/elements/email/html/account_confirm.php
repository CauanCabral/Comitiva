<p>
Olá <?php echo $user['User']['name'];?>,
<br />
Esta mensagem é uma confirmação da criação de sua conta no sistema de inscrição de eventos do PHPMS.
<br />
Você está registrado com o usuário <b><?php echo $user['User']['username']; ?></b>.
<br />
Para confirmar a criação da conta, acesse o link: <a href="<?php echo $html->link(array('controller' => 'users', 'action' => 'account_confirm', $token)); ?>"><?php echo $html->link(array('controller' => 'users', 'action' => 'account_confirm', $token)); ?></a>.
<br />
Este link é válido por 24h.
<br />
Caso não tenha feito o registro, apenas ignore a mensagem e a conta será removida.
</p>

<p>
Atenciosamente,

PHPMS - Grupo de Desenvolvedores PHP de Mato Grosso do Sul
</p>