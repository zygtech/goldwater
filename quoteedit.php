<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link,'SELECT * FROM `clients` WHERE fullname="' . $_POST['clientname'] . '" OR company="' . $_POST['clientname'] . '";');
	$client = mysqli_fetch_array($result);
	$clientid = $client['id'];
	if ($clientid=='' && $_POST['clientname']!='') {
		mysqli_query($link,'INSERT INTO `clients` VALUES (0,"","' . strip_tags($_POST['clientname']) . '","","","","","","","NEW",3);');
		$clientid=mysqli_insert_id($link);
	}
	$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $clientid . ';');
	$client = mysqli_fetch_array($result);
	if ($client['company']!='') $clientinfo = $client['company'] . "\n";
	if ($client['fullname']!='') $clientinfo .= $client['fullname'] . "\n";
	if ($client['address']!='') $clientinfo .= $client['address'] . "\n";
	if (strip_tags($_POST['name'])!='' && $_SESSION['login']!='' && $_POST['id']=='' && $clientid!='')
		mysqli_query($link,'INSERT INTO `quotes` VALUES (0,"' . strip_tags($_POST['name']) . '",' . $clientid . ',"' . strip_tags($clientinfo) . '","' . strip_tags($_POST['description']) . '",NOW(),"' . $_SESSION['login'] . '");');
	elseif (strip_tags($_POST['name'])!='' && $_SESSION['login']!='' && $clientid!='')
		mysqli_query($link,'UPDATE `quotes` SET name="' . strip_tags($_POST['name']) . '", client=' . $clientid . ', clientinfo="' . strip_tags($clientinfo) . '", description="' . strip_tags($_POST['description']) . '" WHERE id=' . $_POST['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/quotes.php"> 
