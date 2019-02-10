<?php
require_once('config.php');
session_start();
if ($_GET['confirm']=='yes' && $_SESSION['company']!='goldwater') {
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_info`;');
	if (mysqli_num_rows($result)>0) {
		$query = 'DROP TABLE `' . $_SESSION['company'] . '_clients`;';
		mysqli_query($link,$query);
		$query = 'DROP TABLE `' . $_SESSION['company'] . '_invoices`;';
		mysqli_query($link,$query);
		$query = 'DROP TABLE `' . $_SESSION['company'] . '_jobs`;';
		mysqli_query($link,$query);
		$query = 'DROP TABLE `' . $_SESSION['company'] . '_quotes`;';
		mysqli_query($link,$query);
		$query = 'DROP TABLE `' . $_SESSION['company'] . '_tasks`;';
		mysqli_query($link,$query);
		$query = 'DROP TABLE `' . $_SESSION['company'] . '_users`;';
		mysqli_query($link,$query);
		$query = 'DROP TABLE `' . $_SESSION['company'] . '_info`;';
		mysqli_query($link,$query);
		unlink('../' . $_SESSION['company'] . '.png');
	};
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/pl/index.php?logout=true"> 
<?php
} else {
?>
<html>

<head>
	<title>Goldwater</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
</head>

<body>
	<div class="container">
<img class="right" src="../logo/<?php echo $_SESSION['company']; ?>.png" />
<h1> Goldwater Business </h1>
</div>
<div class="ribbonlogin"><div class="container">
<h2> USUŃ KONTO </h2>
</div></div>
<div class="mainlogin"><div class="container">
<center>Czy na pewno chcesz usunąć konto tej firmy: <?php echo $_SESSION['company']; ?>? <a href="deleteaccount.php?confirm=yes">Tak</a></center>
</div></div>
<div class="ribbonlogin"><div class="container">
&nbsp;
</div></div>
</body>

</body>

</html>
<?php 
}
?>
