<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	if ($_SESSION['login']!='' && $_GET['id']!='') {
		$result=mysqli_query($link,'SELECT * FROM `clients` WHERE fullname="' . $_GET['id'] . '" OR company="' . $_GET['id'] . '";');
		$client = mysqli_fetch_array($result);
		echo $client['mobile'];
	}
	mysqli_free_result($result);
	mysqli_close($link);
?>&nbsp;