<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$n=0;
	foreach(preg_split('~[\r\n]+~', strip_tags($_POST['quantity'])) as $line){
		$quantity[$n]=$line; 
		$n++;
	}
	$n=0;
	foreach(preg_split('~[\r\n]+~', strip_tags($_POST['amount'])) as $line){
		$amount[$n]=$line; 
		$n++;
	}
	$total=0;
	for($l=0;$l<=$n;$l++) {
		if ($quantity[$l]!='') $total=$total+$quantity[$l]*$amount[$l]; else $total=$total+$amount[$l];
	}
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
	if ($_SESSION['login']!='' && $_POST['id']=='' && $clientid!='')
		mysqli_query($link,'INSERT INTO `invoices` VALUES (0,' . $clientid . ',"' . strip_tags($clientinfo) . '","' . strip_tags($_POST['description']) . '","' . strip_tags($_POST['quantity']) . '","' . strip_tags($_POST['amount']) . '",' . $total . ',NOW(),"' . $_SESSION['login'] . '");');
	elseif ($_SESSION['login']!='' && $clientid!='')
		mysqli_query($link,'UPDATE `invoices` SET client=' . $clientid . ', clientinfo="' . strip_tags($clientinfo) . '", description="' . strip_tags($_POST['description']) . '", quantity="' . strip_tags($_POST['quantity']) . '", amount="' . strip_tags($_POST['amount']) . '", total=' . $total . ' WHERE id=' . $_POST['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/invoices.php">