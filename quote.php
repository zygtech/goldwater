<?php
	require_once('config.php');
	session_start();
	if ($_SESSION['login']!='') {
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		if ($_GET['id']!='') {
			$result = mysqli_query($link,'SELECT * FROM `quotes` WHERE id=' . $_GET['id'] . ';');
			$quote = mysqli_fetch_array($result);
		}
		?>
<html>

<head>
	<title>Quote Edit</title>
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
	<h2> QUOTE EDIT </h2>
	</div></div>
	<div class="main"><div class="container">
	<form action="quoteedit.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $quote['id']; ?>" />
	<table>
	<tr><td>Quote ID:<br /><div class="field"><?php if ($quote['id']!='') echo 'QTE' . sprintf('%04d',$quote['id']); ?>&nbsp;</div></td>
	<td>Date of creation:<br /><div class="field"><?php if ($quote['creation']!='') echo $quote['creation']; else echo date('Y-m-d'); ?>&nbsp;</div></td></tr>
	<?php
$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $quote['client'] . ';');
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
	$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $quote['client'] . ';');
	$client = mysqli_fetch_array($result);
	?>
	<td>Client mobile:<br /><div id="phone" class="field"><?php if ($client['mobile']!='') echo $client['mobile']; ?>&nbsp;</div></td></tr>
	</table><br />
	Quote short description:<br />
	<input type="text" name="name" value="<?php echo $quote['name']; ?>" maxlength="50" /><br /><br />
	Description:
	<textarea class="desc" name="description" onkeyup="limitTextarea(this,20,100)"><?php echo $quote['description']; ?></textarea>
	<br /><br />
	<table>
	<tr><td></td><td>Created by:<br /><div class="field"><?php if ($quote['added']!='') {
		$result = mysqli_query($link,'SELECT * FROM `users` WHERE name="' . $quote['added'] . '";');
		$user = mysqli_fetch_array($result);
		echo $quote['added'] . ' - ' . $user['mail']; 
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
