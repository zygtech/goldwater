<?php
	require_once('config.php');
	session_start();
	foreach ($_POST['emails'] as $email) 
		mail($email, $_POST['title'], $_POST['content']);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/clients.php">
