<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link,'SELECT * FROM `' . $_POST['company'] . '_users` WHERE name="' . $_POST['login'] . '";');
	if ($_POST['mail']!='' && $_POST['login']!='' && $_POST['pass']!='' && !(mysqli_num_rows($result)>0)) {
		$query = 'INSERT INTO `' . $_SESSION['company'] . '_users` VALUES (0,"' . $_POST['login'] . '","' . $_POST['mail'] . '","' . md5($_POST['pass']) . '");';
		mysqli_query($link,$query);
	};
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/pl/settings.php" />
