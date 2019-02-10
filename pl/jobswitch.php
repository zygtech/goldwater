<?php
/*
 * jobswitch.php
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
	if (strip_tags($_GET['id'])!='' && $_SESSION['login']!='' && $_GET['stage']!='')
		mysqli_query($link,'UPDATE `' . $_SESSION['company'] . '_jobs` SET stage="' . strip_tags($_GET['stage']) . '", finished=NULL WHERE id=' . $_GET['id'] . ';');
	if (strip_tags($_GET['id'])!='' && $_SESSION['login']!='' && $_GET['priority']!='')
		mysqli_query($link,'UPDATE `' . $_SESSION['company'] . '_jobs` SET priority=' . strip_tags($_GET['priority']) . ' WHERE id=' . $_GET['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>
