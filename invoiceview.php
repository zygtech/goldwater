<?php
/*
 * invoiceview.php
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
	if ($_GET['id']!='') {
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		$result = mysqli_query($link,'SELECT * FROM `' . $_GET['company'] . '_invoices` WHERE id=' . $_GET['id'] . ';');
		$row = mysqli_fetch_array($result);
		$result = mysqli_query($link,'SELECT * FROM `' . $_GET['company'] . '_clients` WHERE id=' . $row['client'] . ';');
		$client = mysqli_fetch_array($result);
		$result = mysqli_query($link,'SELECT * FROM `' . $_GET['company'] . '_info`;');
		$info = mysqli_fetch_array($result);
		mysqli_free_result($result);
		$html = '<body>
	<div style="text-align: center;"><img class="logo" src="logo/' . $_GET['company'] . '.png" /></div>
	<table class="top"><tr><td style="background: lightgray;">Receipt</td><td style="background: #e7e7e8;">' . $row['invoiceid'] . '</td><td></td><td></td><td style="background: lightgray;">Date</td><td style="background: #e7e7e8;">' . $row['creation'] . '</td></table>
	<table class="main"><tr><th style="background: ' . $info['color'] . ';">Payee Name:</th><th style="background: ' . $info['color'] . ';"></th><th style="background: ' . $info['color'] . ';"></th></tr>
	<tr><td>' . $info['display'] . '<br />' . str_replace("\n","<br />",$info['address']) . '</td>
	<td><strong>CONTACT:</strong><br />' . str_replace("\n","<br />",$info['contact']) . '</td>
	<td style="width: 45%;"><strong>BANK DETAILS:</strong><br />' . str_replace("\n","<br />",$row['bank']) . '</td>
	</table>
	<table class="main"><tr><th style="background: ' . $info['color'] . ';">Payer Name:</th><th style="background: ' . $info['color'] . ';"></th><th style="background: ' . $info['color'] . ';"></th></tr>
	<tr><td>' . nl2br($row['clientinfo']);
	if ($client['nip']!='') $html .= 'TIN: ' . $client['nip'];
	$html .=  '</td><td><strong>';
	if ($client['mail']!='' || $client['mobile']!='') $html .= 'CONTACT:';
	$html .= '</strong><br />' . $client['mail'] . '<br />' . $client['mobile'] . '</td>
	<td style="width: 45%;"></td>
	</table>
	<table class="main description"><tr><th style="background: ' . $info['color'] . '; width: 5%;">No.</th><th style="background: ' . $info['color'] . '; width: 40%;">Description</th><th style="background: ' . $info['color'] . '; width: 15%;">Type</th><th style="background: ' . $info['color'] . '; width: 10%;">Netto</th><th style="background: ' . $info['color'] . '; width: 10%;">VAT (%)</th><th style="background: ' . $info['color'] . '; width: 10%;">VAT value</th><th style="background: ' . $info['color'] . '; width: 10%;">Total</th></tr>
	<tr><td style="text-align: center;">';
	foreach(preg_split('~[\n]+~', $row['description']) as $line){
		$i++;
		if ($line!='') $html .= $i . '<br />';
    }
    $html .= '</td><td>' . nl2br($row['description']) . '</td>
	<td style="height: 70mm;">' . nl2br($row['type']) . '</td><td class="right">';
	foreach(preg_split('~[\n]+~', $row['netto']) as $line){
		if ($line==0) $html .= '<br />'; else $html .= number_format($line,2) . '<br />'; 
	} 
	$html .= '</td><td>' . nl2br($row['vat']) . '</td>';
	$n=0;
	foreach(preg_split('~[\n]+~', $row['netto']) as $line){
		if ($line==0) $netto[$n] = 0; else $netto[$n] = $line; 
		$n++;
	} 
	$n=0;
	foreach(preg_split('~[\n]+~', $row['vat']) as $line){
		if ($line==0) $vat[$n] = 0; else $vat[$n] = $line; 
		$n++;
	} 
	for($i=0;$i<15;$i++) {
		if ($netto[$i]==0) {
			$vatvalue .= '<br />';
			$total .= '<br />';
		} else {
			$tmp = $netto[$i]*$vat[$i]/100;
			$vatvalue .= number_format($tmp,2) . '<br />';
			$tmp = $netto[$i]+$tmp;
			$total .= number_format($tmp,2) . '<br />';
		}
	}
	$html .= '<td class="right">' . $vatvalue . '</td><td class="right">' . $total . '</td></tr></table>
	<table class="main"><tr><th style="background: ' . $info['color'] . ';">Additional information</td></tr><tr><td style="height: 20mm;">' . $row['info'] . '</td></tr></table>
	<table class="top"><tr><td></td><td></td><td></td><td></td><td style="background: ' . $info['color'] . '; color: #ffffff;">TOTAL</td><td class="right" style="background: #e7e7e8;">';
	if ($row['currency']=='USD') $html .= '$'; if ($row['currency']=='EUR') $html .= '€'; if ($row['currency']=='GBP') $html .= '£';
	$html .= number_format($row['total'],2);
	if ($row['currency']=='PLN') $html .= ' zł';
	$html .= '</td></tr></table>
	<div id="footer" style="text-align: center;">
    This document is original electronic version.
	</div>
	</div>
	</body>';
}
?>
