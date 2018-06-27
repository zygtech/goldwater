<?php
/*
 * jobedit.php
 * 
 * Copyright 2018 Krzysztof Hrybacz <krzysztof@zygtech.pl>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
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
	if ($_POST['stage']=='') $_POST['stage']='In progress';
	if (strip_tags($_POST['name'])!='' && $_SESSION['login']!='' && $_POST['id']=='' && $clientid!='')
		mysqli_query($link,'INSERT INTO `jobs` VALUES (0,"' . strip_tags($_POST['name']) . '",' . $clientid . ',"' . strip_tags($_POST['description']) . '",NOW(),"' . strip_tags($_POST['stage']) . '","' . strip_tags($_POST['info']) . '","' . $_SESSION['login'] . '",NULL,"' . $_POST['required'] . '",3,0);');
	elseif (strip_tags($_POST['name'])!='' && $_SESSION['login']!='' && $clientid!='')
		mysqli_query($link,'UPDATE `jobs` SET name="' . strip_tags($_POST['name']) . '", client=' . $clientid . ', description="' . strip_tags($_POST['description']) . '", stage="' . strip_tags($_POST['stage']) . '", info="' . strip_tags($_POST['info']) . '", finished=NULL, required="' . $_POST['required'] . '" WHERE id=' . $_POST['id'] . ';');
	if ($_GET['id']!='' && $_SESSION['login']!='')
		mysqli_query($link,'UPDATE `jobs` SET archive=0 WHERE id=' . $_GET['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/jobs.php"> 
