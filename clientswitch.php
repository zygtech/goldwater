<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	if (strip_tags($_GET['id'])!='' && $_SESSION['login']!='' && $_GET['category']!='')
		mysqli_query($link,'UPDATE `clients` SET category="' . strip_tags($_GET['category']) . '" WHERE id=' . $_GET['id'] . ';');
	if (strip_tags($_GET['id'])!='' && $_SESSION['login']!='' && $_GET['priority']!='')
		mysqli_query($link,'UPDATE `clients` SET priority=' . strip_tags($_GET['priority']) . ' WHERE id=' . $_GET['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>