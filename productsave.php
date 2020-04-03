<?php
/*
 * invoicepdf.php
 * 
 * Copyright 2018 Krzysztof Hrybacz <krzysztof@zygtech.pl>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<?php
require_once('config.php');
include('productview.php');
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
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$mpdf->Output('PR' . sprintf('%04d',$_GET['id']) . '.pdf','D');
exit;
}
?>
