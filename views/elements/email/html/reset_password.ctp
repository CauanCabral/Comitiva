<p>
Olá <?php echo $user['User']['name'];?>,
<br />
Foi solicitado através de nosso sistema de inscrição em eventos a recuperação de sua senha.
<br />
Para dar prosseguimento a recuperação da senha, acesse o endereço: <a href="<?php echo $html->link(array('controller' => 'users', 'action' => 'reset_password', $token)); ?>"><?php echo $html->link(array('controller' => 'users', 'action' => 'reset_password', $token)); ?></a>.
<br />
Este link é válido por 24h.
<br />
Caso não tenha feito a solicitação, ignore a mensagem.
</p>

<p>
Atenciosamente,

PHPMS - Grupo de Desenvolvedores PHP de Mato Grosso do Sul
</p>