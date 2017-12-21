<?php
	require_once('config.php');
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$login = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['user']);
	$result = mysqli_query($link,'SELECT * FROM `users` WHERE name="' . $login . '";');
	$check = mysqli_fetch_array($result);
	if ($check['pass']==md5($_POST['pass'])) {
	session_start();
	$_SESSION['login']=$login;
?>
	<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/tasks.php"> 
<?php
	}
	mysqli_free_result($result);
	mysqli_close($link);
?>
