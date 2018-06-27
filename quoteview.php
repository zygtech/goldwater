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
		$result = mysqli_query($link,'SELECT * FROM `quotes` WHERE id=' . $_GET['id'] . ';');
		$row = mysqli_fetch_array($result);
		$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $row['client'] . ';');
		$client = mysqli_fetch_array($result);
		mysqli_free_result($result);
		?>
	<body>
	<div style="position: absolute; text-align: right; top: 35mm; width: 180mm; margin: 0 auto; line-height: 16px; font-size: 14px;">
	contact <span style="color: rgb(240, 147, 0); font-weight: bold;">YOURNAME</span><br />
	+44 100 200 3000<br /><br />
	yourmail@company.com<br />
	<span style="color: rgb(240, 147, 0); font-weight: bold;">www.yourwebsite.com</span>
	</div>
	<div style="text-align: center;"><img class="logo" src="logo.png" /></div>
	<table class="top"><tr><td style="background: lightgray;">Quote</td><td style="background: #e7e7e8;"><?php echo 'QTE' . sprintf('%04d',$row['id']); ?></td><td></td><td></td><td style="background: lightgray;">Date</td><td style="background: #e7e7e8;"><?php echo $row['creation']; ?></td></table>
	<table class="main"><tr><th>Client's name:</th><th></th><th></th></tr>
	<tr><td><?php echo nl2br($row['clientinfo']); ?></td>
	<td><strong><?php if ($client['mail']!='' || $client['mobile']!='') echo 'CONTACT:'; ?></strong><br /><?php echo $client['mail']; ?><br /><?php echo $client['mobile']; ?></td>
	<td></td></tr>
	</table>
	<table class="main"><tr><th style="text-align: center;"><?php echo $row['name']; ?></th></tr></table>
	<table class="main description">
	<tr><th>Description</th></tr>
	<tr><td style="text-align: left; width: 75%; height: 130mm;"><?php echo nl2br($row['description']); ?></td></tr>
	</table>
	</body>
<?php
	}
?>

