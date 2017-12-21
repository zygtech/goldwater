<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	if ($_POST['job']!='' && strip_tags($_POST['name'])!='' && $_SESSION['login']!='')
		mysqli_query($link,'INSERT INTO `tasks` VALUES (0,' . $_POST['job'] . ',"' . strip_tags($_POST['name']) . '","' . $_POST['user'] . '",0);');
	if ($_GET['id']!='' && $_SESSION['login']!='')
		mysqli_query($link,'UPDATE `tasks` SET archive=0 WHERE id=' . $_GET['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/task<?php echo $_GET['return']; ?>.php?id=<?php echo $_POST['job']; ?><?php echo $_GET['job']; ?>"> 
