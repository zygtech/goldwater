<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	if (strip_tags($_GET['id'])!='' && $_SESSION['login']!='' && $_GET['stage']!='')
		mysqli_query($link,'UPDATE `jobs` SET stage="' . strip_tags($_GET['stage']) . '", finished=NULL WHERE id=' . $_GET['id'] . ';');
	if (strip_tags($_GET['id'])!='' && $_SESSION['login']!='' && $_GET['priority']!='')
		mysqli_query($link,'UPDATE `jobs` SET priority=' . strip_tags($_GET['priority']) . ' WHERE id=' . $_GET['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>