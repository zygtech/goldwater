<?php
/*
 * quoteview.php
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
	if ($_GET['id']!='') {
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		$result = mysqli_query($link,'SELECT * FROM `' . $_GET['company'] . '_products` WHERE id=' . $_GET['id'] . ';');
		$row = mysqli_fetch_array($result);
		$result = mysqli_query($link,'SELECT * FROM `' . $_GET['company'] . '_info`;');
		$info = mysqli_fetch_array($result);
		mysqli_free_result($result);
		$html = '<body>
	<div style="position: absolute; text-align: right; top: 55mm; width: 180mm; margin: 0 auto; line-height: 16px; font-size: 14px;">
	<span style="color: ' . $info['color'] . '; font-weight: bold;">' . $info['display'] . '</span><br />' . str_replace("\n","<br />",$info['contact']) . '</div>
	<div style="text-align: center; height: 200px;"><img class="logo" src="../logo/' . $_GET['company'] . '.png" /></div>
	<table class="top"><tr><td style="background: lightgray;">Produkt</td><td style="background: #e7e7e8;">' . 'PR' . sprintf('%04d',$_GET['id']) . '</td><td></td><td></td><td style="background: lightgray;">Date</td><td style="background: #e7e7e8;">' . date('Y-m-d') . '</td></table>
	<table class="main description">';
	if ($row['name']!='') $html .= '
		<tr><th style="background: ' . $info['color'] . ';">Nazwa</th></tr>
		<tr><td style="text-align: center;">' . $row['name'] . '</td></tr>';
	if ($row['sku']!='') $html .= '
	<tr><th style="background: ' . $info['color'] . ';">SKU</th></tr>
	<tr><td style="text-align: center;">' . $row['sku'] . '</td></tr>';
	if ($row['price']!='') $html .= '
	<tr><th style="background: ' . $info['color'] . ';">Cena</th></tr>
	<tr><td style="text-align: center;">' . number_format($row['price'],2,'.',',') . '</td></tr>';
	if ($row['vat']!='') $html .= '
	<tr><th style="background: ' . $info['color'] . ';">Vat</th></tr>
	<tr><td style="text-align: center;">' . $row['vat'] . '</td></tr>';
	if ($row['category']!='') $html .= '
	<tr><th style="background: ' . $info['color'] . ';">Kategoria</th></tr>
	<tr><td style="text-align: center;">' . $row['category'] . '</td></tr>';
	if ($row['description']!='') $html .= '
	<tr><th style="background: ' . $info['color'] . ';">Opis</th></tr>
	<tr><td style="text-align: center;">' . $row['description'] . '</td></tr>';
	$html .= '
	</td></tr>
	</table>
	</body>';
	}

