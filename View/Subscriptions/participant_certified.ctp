<?php
$xpdf->SetAutoPageBreak( true, 0 );
$xpdf->SetMargins(0,0,0);
$xpdf->SetFont('Aller-Std-Rg','',20);
$xpdf->SetTextColor(130,130,130);

$xpdf->AddPage();
$xpdf->Image($xpdf->xheaderimage, 0,0,0,0,null,null,null,true,'300', 'C', null, null, null, null, null, true);
$xpdf->MultiCell(130,10, $user['fullName'], null, 'C', null, null, 85,125);
$xpdf->SetFont('Aller-Std-Rg','',16);
$xpdf->MultiCell(130,10, 'Participou do PHPMS Conf 2012 realizado no Senac/MS nos dias 17 e 18 de Agosto de 2012 e organizado pelo PHPMS', null, 'C', null, null, 85,135);

$xpdf->Output('certificado.pdf', 'I');
?>