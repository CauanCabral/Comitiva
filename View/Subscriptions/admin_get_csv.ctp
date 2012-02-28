<?php
$this->Csv->addRow($fields);

foreach($users as $user)
{
	$this->Csv->addRow(array_values($user['User']));
}

echo $this->Csv->render("inscritos");
?>