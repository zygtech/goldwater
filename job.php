<?php
/*
 * job.php
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
			$result = mysqli_query($link,'SELECT * FROM `jobs` WHERE id=' . $_GET['id'] . ';');
			$job = mysqli_fetch_array($result);
		}
		?>
<html>

<head>
	<title>Job Edit</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
	<h2> JOB EDIT </h2>
	</div></div>
	<div class="main"><div class="container">
	<form action="jobedit.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $job['id']; ?>" />
	<table>
	<tr><td>Job ID:<br /><div class="field"><?php if ($job['id']!='') echo 'JB' . sprintf('%04d',$job['id']); ?>&nbsp;</div></td>
	<td>Date of creation:<br /><div class="field"><?php if ($job['creation']!='') echo $job['creation']; else echo date('Y-m-d'); ?>&nbsp;</div></td></tr>
	<?php
	$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $job['client'] . ';');
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
	$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $job['client'] . ';');
	$client = mysqli_fetch_array($result);
	?>
	<td>Client mobile:<br /><div class="field" id="phone"><?php if ($client['mobile']!='') echo $client['mobile']; ?>&nbsp;</div></td></tr>
	</table><br />
	Job short description:<br />
	<input type="text" name="name" value="<?php echo $job['name']; ?>" maxlength="50" /><br /><br />
	Job full description:<br />
	<textarea name="description"><?php echo $job['description']; ?></textarea><br /><br />
	<table>
	<tr>
	<td>Stage: <br /><select name="stage">
	<option <?php if ($job['stage']=='1-Proposal') echo 'selected'; ?>>1-Proposal</option>
	<option <?php if ($job['stage']=='2-Valuation') echo 'selected'; ?>>2-Valuation</option>
	<option <?php if ($job['stage']=='3-Waiting') echo 'selected'; ?>>3-Waiting</option>
	<option <?php if ($job['stage']=='4-Project') echo 'selected'; ?>>4-Project</option>
	<option <?php if ($job['stage']=='5-Send to client') echo 'selected'; ?>>5-Send to client</option>
	<option <?php if ($job['stage']=='6-Acceptation') echo 'selected'; ?>>6-Acceptation</option>
	<option <?php if ($job['stage']=='7-Invoice') echo 'selected'; ?>>7-Invoice</option>
	<option <?php if ($job['stage']=='8-Printing') echo 'selected'; ?>>8-Printing</option>
	<option disabled <?php if ($job['stage']=='9-Finished') echo 'selected'; ?>>9-Finished</option>
	</select></td>
	<td>Created by:<br /><div class="field"><?php if ($job['added']!='') {
		$result = mysqli_query($link,'SELECT * FROM `users` WHERE name="' . $job['added'] . '";');
		$user = mysqli_fetch_array($result);
		echo $job['added'] . ' - ' . $user['mail']; 
	}
	else {
		$result = mysqli_query($link,'SELECT * FROM `users` WHERE name="' . $_SESSION['login'] . '";');
		$user = mysqli_fetch_array($result);
		echo $_SESSION['login'] . ' - ' . $user['mail']; 
	}
	?>&nbsp;</div></td></tr></table><br />
	Additional info:<br />
	<textarea name="info" onkeyup="limitTextarea(this,5,100)"><?php echo $job['info']; ?></textarea><br /><br />
	<table>
	<tr><td>Required by: <br /><input type="date" name="required" value="<?php echo $job['required']; ?>" /></td>
	<td>Finished on:<br /><div class="field"><?php echo $job['finished']; ?>&nbsp;</div></td></tr>
	</table><br />
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
