<?php
/*
 * invoiceedit.php
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
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE fullname="' . $_POST['clientname'] . '" OR company="' . $_POST['clientname'] . '";');
	$client = mysqli_fetch_array($result);
	$clientid = $client['id'];
	if ($clientid=='' && $_POST['clientname']!='') {
		mysqli_query($link,'INSERT INTO `' . $_SESSION['company'] . '_clients` VALUES (0,"","' . strip_tags($_POST['clientname']) . '","","","","","","","NEW",3,"");');
		$clientid=mysqli_insert_id($link);
	}
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE id=' . $clientid . ';');
	$client = mysqli_fetch_array($result);
	if ($client['company']!='') $clientinfo = $client['company'] . "\n";
	if ($client['fullname']!='') $clientinfo .= $client['fullname'] . "\n";
	if ($client['address']!='') $clientinfo .= $client['address'] . "\n";
	$netto="";
	$vat="";
	$total=0;
	for ($i=0;$i<15$i++) {
		$description.=$_POST['description' . $i] . "\n";
		$type.=$_POST['type' . $i] . "\n";
		$netto.=$_POST['netto' . $i] . "\n";
		$vat.=$_POST['vat' . $i] . "\n";
		$total=number_format($total+$_POST['netto' . $i]+$_POST['netto' . $i]*$_POST['vat' . $i]/100,2,'.','');
	}
	if ($_SESSION['login']!='' && $_POST['id']=='' && $clientid!='')
		mysqli_query($link,'INSERT INTO `' . $_SESSION['company'] . '_invoices` VALUES (0,' . $clientid . ',"' . strip_tags($clientinfo) . '","' . strip_tags($description) . '","' . strip_tags($type) . '","' . strip_tags($netto) . '","' . $total . '",NOW(),"' . $_SESSION['login'] . '","' . strip_tags($vat) . '","' . strip_tags($_POST['invoiceid']) . '","' . strip_tags($_POST['bank']) . '","' . strip_tags($_POST['currency']) . '","' . strip_tags($_POST['info']) . '");');
	elseif ($_SESSION['login']!='' && $clientid!='')
		mysqli_query($link,'UPDATE `' . $_SESSION['company'] . '_invoices` SET client=' . $clientid . ', clientinfo="' . strip_tags($clientinfo) . '", description="' . strip_tags($description) . '", type="' . strip_tags($type) . '", netto="' . strip_tags($netto) . '", total="' . $total . '", vat="' . strip_tags($vat) . '", invoiceid="' . strip_tags($_POST['invoiceid']) . '", bank="' . strip_tags($_POST['bank']) . '", currency="' . strip_tags($_POST['currency']) . '", info="' . strip_tags($_POST['info']) . '" WHERE id=' . $_POST['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/invoices.php">
