<?php
$xpdf->SetAutoPageBreak( true, 0 );
$xpdf->SetMargins(0,0,0);
$xpdf->SetFont(null,'',20);
$xpdf->SetTextColor(130,130,130);

$xpdf->AddPage();
$xpdf->Image($xpdf->xheaderimage, 0,0,0,0,null,null,null,true,'300', 'C', null, null, null, null, null, true);
$xpdf->MultiCell(130,10, $user['fullName'], null, 'C', null, null, 85,125);
$xpdf->SetFont(null,'',16);

$pos = explode(',', $subscription['Event']['certified_position']);

if (count($pos) < 2) {
	$pos = array(130, 10);
}

$xpdf->MultiCell($pos[0],$pos[1], $subscription['Event']['certified_description'], null, 'C', null, null, 85,135);
$xpdf->Output('certificado.pdf', 'I');
?>
