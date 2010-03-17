<p>
Olá <?php echo $user;?>,
<br />
Foi solicitado através de nosso sistema de inscrição em eventos a recuperação de sua senha.
<br />
Para dar prosseguimento a recuperação da senha, acesse o endereço: <?php echo $html->link($html->link(array('controller' => 'users', 'action' => 'reset_password', $token)), array('controller' => 'users', 'action' => 'reset_password', $token)); ?>.
<br />
Este link é válido por 24h.
<br />
Caso não tenha feito a solicitação, ignore a mensagem.
</p>

<p>
Atenciosamente,

PHPMS - Grupo de Desenvolvedores PHP de Mato Grosso do Sul
</p>