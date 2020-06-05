<?php
/*
 * invoices.php
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
 		header('Content-Description: CSV Export');
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="export.csv"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		require_once('config.php');
		session_start();
		if ($_SESSION['login']=='') exit('Login error! <a href="' . $url . '/">Back</a>');			
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='')
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_invoices`.id,`' . $_SESSION['company'] . '_invoices`.invoiceid,`' . $_SESSION['company'] . '_invoices`.currency,`' . $_SESSION['company'] . '_invoices`.client,`' . $_SESSION['company'] . '_invoices`.total,`' . $_SESSION['company'] . '_invoices`.creation,`' . $_SESSION['company'] . '_clients`.fullname,`' . $_SESSION['company'] . '_clients`.company,`' . $_SESSION['company'] . '_clients`.address,`' . $_SESSION['company'] . '_clients`.mobile,`' . $_SESSION['company'] . '_clients`.mail FROM `' . $_SESSION['company'] . '_invoices` INNER JOIN `' . $_SESSION['company'] . '_clients` ON `' . $_SESSION['company'] . '_invoices`.client = `' . $_SESSION['company'] . '_clients`.id ORDER BY invoiceid,id;');
		else
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_invoices`.id,`' . $_SESSION['company'] . '_invoices`.invoiceid,`' . $_SESSION['company'] . '_invoices`.currency,`' . $_SESSION['company'] . '_invoices`.client,`' . $_SESSION['company'] . '_invoices`.total,`' . $_SESSION['company'] . '_invoices`.creation,`' . $_SESSION['company'] . '_clients`.fullname,`' . $_SESSION['company'] . '_clients`.company,`' . $_SESSION['company'] . '_clients`.address,`' . $_SESSION['company'] . '_clients`.mobile,`' . $_SESSION['company'] . '_clients`.mail FROM `' . $_SESSION['company'] . '_invoices` INNER JOIN `' . $_SESSION['company'] . '_clients` ON `' . $_SESSION['company'] . '_invoices`.client = `' . $_SESSION['company'] . '_clients`.id ORDER BY ' . $_GET['sort'] . $order . ',invoiceid,id;');
		echo '"ID FAKTURY","NAZWISKO KLIENTA","FIRMA KLIENTA","ADRES KLIENTA","TELEFON KLIENTA","E-MAIL KLIENTA","DATA STWORZENIA","WARTOŚĆ FAKTURY","WALUTA FAKTURY"';
		echo "\n";
		while ($row = mysqli_fetch_array($result))
			if ($_GET['q']=='' || strpos(strtolower($row['id']), strtolower($_GET['q']))!==false || strpos(strtolower($row['company']), strtolower($_GET['q']))!==false || strpos(strtolower($row['fullname']), strtolower($_GET['q']))!==false || strpos(strtolower($row['creation']), strtolower($_GET['q']))!==false || strpos(strtolower($row['total']), strtolower($_GET['q']))!==false) {
				echo $row['invoiceid'] . ',"' . $row['fullname'] . '","' . $row['company'] . '","' . $row['address'] . '","' . $row['mobile'] . '","' . $row['mail'] . '",' . $row['creation'] . ',' . number_format($row['total'],2,'.','') . ',' . $row['currency'];
				echo "\n";
			}
		mysqli_free_result($result);
		mysqli_close($link);
		?>
