<?php
$xpdf->SetAutoPageBreak( true, 28 );
$xpdf->SetMargins(20, 35, 20);

$xpdf->SetCreator('Comitiva - Sistema de Gerenciamento de Eventos');
$xpdf->SetAuthor('PHPMS');
$xpdf->mainTitle =  '';
$xpdf->xfootertext = '';
$xpdf->xheaderimage = '';
$xpdf->xheadertext = '';
$xpdf->date = date('d-m-Y');

$xpdf->AddPage();
$xpdf->Cell(160, 0, $user['name']);
$xpdf->Output('certificado.pdf', 'I');

?>