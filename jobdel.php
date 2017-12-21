<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link,'SELECT * FROM `jobs` WHERE id=' . $_GET['id'] . ';');
	$archive = mysqli_fetch_array($result)['archive'];
	if ($_SESSION['login']!='' && $_GET['id']!='' && $archive==1) {
		mysqli_query($link,'DELETE FROM `jobs` WHERE id=' . $_GET['id'] . ';');
		mysqli_query($link,'DELETE FROM `tasks` WHERE job=' . $_GET['id'] . ';');
	} elseif ($_SESSION['login']!='' && $_GET['id']!='')
		mysqli_query($link,'UPDATE `jobs` SET archive=1, finished=NOW(), stage="9-Finished" WHERE id=' . $_GET['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/jobs.php"> 
