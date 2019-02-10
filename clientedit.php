<?php
/*
 * clientedit.php
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
	if ($_POST['id']=='') 
		mysqli_query($link,'INSERT INTO `' . $_SESSION['company'] . '_clients` VALUES (0,"' . strip_tags($_POST['fullname']) . '","' . strip_tags($_POST['company']) . '","' . strip_tags($_POST['address']) . '","' . strip_tags($_POST['mobile']) . '","' . strip_tags($_POST['mail']) . '","' . strip_tags($_POST['www']) . '","' . strip_tags($_POST['info']) . '","' . str_replace("\\","\\\\",strip_tags($_POST['folder'])) . '","' . strip_tags($_POST['category']) . '",3,"' . strip_tags($_POST['nip']) . '");');
	else
		mysqli_query($link,'UPDATE `' . $_SESSION['company'] . '_clients` SET fullname="' . strip_tags($_POST['fullname']) . '", company="' . strip_tags($_POST['company']) . '", address="' . strip_tags($_POST['address']) . '", mobile="' . strip_tags($_POST['mobile']) . '", mail="' . strip_tags($_POST['mail']) . '", www="' . strip_tags($_POST['www']) . '", info="' . strip_tags($_POST['info']) . '", folder="' . str_replace("\\","\\\\",strip_tags($_POST['folder'])) . '", category="' . strip_tags($_POST['category']) . '", nip="' . strip_tags($_POST['nip']) . '" WHERE id=' . $_POST['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/clients.php">
