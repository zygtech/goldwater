<?php
/*
 * invoice.php
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
	if ($_SESSION['login']!='') {
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		if ($_GET['id']!='') {
			$result = mysqli_query($link,'SELECT * FROM `invoices` WHERE id=' . $_GET['id'] . ';');
			$invoice = mysqli_fetch_array($result);
		}
		?>
<html>

<head>
	<title>Invoice Edit</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="limit.js"></script>
	<style>
		td { width: 50% !important; }
	</style>
	<script>
		function phone(sel)
		{
			$("#phone").load('phone.php?id='+sel.value.replace(/ /g,"%20"));
		}
	</script>
</head>

<body>
	<div class="container">
	<img class="right" src="logo.png" />
	<h1> Welcome: <?php echo $_SESSION['login']; ?> <span class="logout">(<a href="index.php?logout=true">log out</a>)</span></h1>
	</div>
	<div class="ribbon"><div class="container">
	<h2> INVOICE EDIT </h2>
	</div></div>
	<div class="main"><div class="container">
	<form action="invoiceedit.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $invoice['id']; ?>" />
	<table>
	<tr><td>Invoice ID:<br /><div class="field"><?php if ($invoice['id']!='') echo 'INV' . sprintf('%04d',$invoice['id']); ?>&nbsp;</div></td>
	<td>Date of creation:<br /><div class="field"><?php if ($invoice['creation']!='') echo $invoice['creation']; else echo date('Y-m-d'); ?>&nbsp;</div></td></tr>
	<?php
	$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $invoice['client'] . ';');
	$client = mysqli_fetch_array($result);
	$result = mysqli_query($link,'SELECT * FROM `clients` ORDER BY company,fullname;;');
	?>
	<tr><td>Company/full name:<br />
	<input type="text" name="clientname" list="clients" onchange="phone(this);" value="<?php 
		if ($client['company']!='') 
			echo $client['company'];
		else
			echo $client['fullname'];
	?>">
	<datalist id="clients">
	<?php
	while ($client = mysqli_fetch_array($result)) {
		if ($client['company']!='') 
			echo '<option>' . $client['company'] . '</option>';
		else
			echo '<option>' . $client['fullname'] . '</option>';
	}
	?>
	</datalist></td>
	<?php 
	$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $invoice['client'] . ';');
	$client = mysqli_fetch_array($result);
	?>
	<td>Client mobile:<br /><div id="phone" class="field"><?php if ($client['mobile']!='') echo $client['mobile']; ?>&nbsp;</div></td></tr>
	</table>
	<table><tr><td style="width: 25% !important;">
	Quantity:
	<textarea class="desc" name="quantity" onkeyup="limitTextarea(this,20,100)"><?php echo $invoice['quantity']; ?></textarea>
	</td><td  style="width: 50% !important;">
	Description:
	<textarea class="desc" name="description" onkeyup="limitTextarea(this,20,100)"><?php echo $invoice['description']; ?></textarea>
	</td><td  style="width: 25% !important;">
	Amount:
	<textarea class="desc" name="amount" onkeyup="limitTextarea(this,20,100)"><?php echo $invoice['amount']; ?></textarea>
	</td></table>
	<table>
	<tr><td></td><td>Created by:<br /><div class="field"><?php if ($invoice['added']!='') {
		$result = mysqli_query($link,'SELECT * FROM `users` WHERE name="' . $invoice['added'] . '";');
		$user = mysqli_fetch_array($result);
		echo $invoice['added'] . ' - ' . $user['mail']; 
	}
	else {
		$result = mysqli_query($link,'SELECT * FROM `users` WHERE name="' . $_SESSION['login'] . '";');
		$user = mysqli_fetch_array($result);
		echo $_SESSION['login'] . ' - ' . $user['mail']; 
	}
	?>&nbsp;</div></td></tr>
	</table><br /><br />
	<input type="submit" value="Save" /><br /><br />
	</form>
	</div></div>
	<div class="ribbon"><div class="container">
	<?php require_once('menu.php'); ?>
	</div></div>
</body>

</html>
<?php
	}
?>
