<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$query = 'UPDATE `' . $_SESSION['company'] . '_info` SET display="' . $_POST['display'] . '", address="' . $_POST['address'] . '", contact="' . $_POST['contact'] . '", bank="' . $_POST['bank'] . '", color="' . $_POST['color'] . '", currency="' . $_POST['currency'] . '" WHERE id=1;';
	mysqli_query($link,$query);
	$_SESSION['display'] = $_POST['display'];
	move_uploaded_file($_FILES['logo']['tmp_name'], './logo/' . $_SESSION['company'] . '.png');
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/settings.php" />
