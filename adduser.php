<?php
/*
 * adduser.php
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
	$result = mysqli_query($link,'SELECT * FROM `' . $_POST['company'] . '_users` WHERE name="' . $_POST['login'] . '";');
	if ($_POST['mail']!='' && $_POST['login']!='' && $_POST['pass']!='' && !(mysqli_num_rows($result)>0)) {
		$query = 'INSERT INTO `' . $_SESSION['company'] . '_users` VALUES (0,"' . $_POST['login'] . '","' . $_POST['mail'] . '","' . md5($_POST['pass']) . '");';
		mysqli_query($link,$query);
	};
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/settings.php" />
