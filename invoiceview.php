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
	session_start();
	if ($_GET['id']!='') {
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		$result = mysqli_query($link,'SELECT * FROM `invoices` WHERE id=' . $_GET['id'] . ';');
		$row = mysqli_fetch_array($result);
		$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $row['client'] . ';');
		$client = mysqli_fetch_array($result);
		mysqli_free_result($result);
		?>
	<body>
	<div style="text-align: center;"><img class="logo" src="logo.png" /></div>
	<table class="top"><tr><td style="background: lightgray;">Receipt</td><td style="background: #e7e7e8;"><?php echo 'INV' . sprintf('%04d',$row['id']); ?></td><td></td><td></td><td style="background: lightgray;">Date</td><td style="background: #e7e7e8;"><?php echo $row['creation']; ?></td></table>
	<table class="main"><tr><th>Payee Name:</th><th></th><th></th></tr>
	<tr><td>YourCompany<br />John Smith<br />East Street 12<br />London, UK</td>
	<td><strong>CONTACT:</strong><br />yourmail@company.com<br />+44 100 200 3000</td>
	<td><strong>BANK DETAILS:</strong><br />YourBank<br />John Smith<br />Account Number: 543 234 14<br />Sort Code: 04 - 01 - 34</td>
	</table>
	<table class="main"><tr><th>Payer Name:</th><th></th><th></th></tr>
	<tr><td><?php echo nl2br($row['clientinfo']); ?></td>
	<td><strong><?php if ($client['mail']!='' || $client['mobile']!='') echo 'CONTACT:'; ?></strong><br /><?php echo $client['mail']; ?><br /><?php echo $client['mobile']; ?></td>
	<td></td>
	</table>
	<table class="main description"><tr><th>Quantity</th><th>Description</th><th>Amount</th></tr>
	<tr><td style="text-align: center; height: 100mm;"><?php 
	foreach(preg_split('~[\n]+~', $row['quantity']) as $line){
		if ($line==0) echo '<br />'; else
			echo $line . '<br />'; 
	} ?></td>
	<td style="text-align: left;"><?php echo nl2br($row['description']); ?></td>
	<td style="text-align: right;"><?php 
	foreach(preg_split('~[\n]+~', $row['amount']) as $line){
		if ($line==0) echo '<br />'; else
			echo '£' . $line . '<br />'; 
	} ?></td>
	</table>
	<table class="top"><tr><td></td><td></td><td></td><td></td><td style="background: rgb(240, 147, 0); color: #ffffff;">TOTAL</td><td style="background: #e7e7e8;">£<?php echo $row['total']; ?></td></tr></table>
	<div id="footer" style="text-align: center;">
	Payment should be made within 14 days from receiving the invoice. If payment is not made we reserve the right to<br />
    charge additional 5% per each calendar month.
	</div>
	</div>
	</body>
<?php
	}
?>

