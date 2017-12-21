<?php
require_once('config.php');
if ($_GET['id']!='') {
include("mpdf/mpdf.php");
$mpdf=new mPDF([
	'margin_left' => 32,
	'margin_right' => 25,
	'margin_top' => 27,
	'margin_bottom' => 25,
	'margin_header' => 16,
	'margin_footer' => 13
]); 
$mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('invoice.css');
$html = file_get_contents($url . '/invoiceview.php?id=' . $_GET['id'],0);
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$mpdf->Output('INV' . sprintf('%04d',$_GET['id']) . '.pdf','D');
exit;
}
?>