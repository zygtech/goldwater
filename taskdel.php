<?php
/*
 * taskdel.php
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
	$result = mysqli_query($link,'SELECT * FROM `tasks` WHERE id=' . $_GET['id'] . ';');
	$archive = mysqli_fetch_array($result)['archive'];
	if ($_SESSION['login']!='' && $_GET['id']!='' && $archive==1)
		mysqli_query($link,'DELETE FROM `tasks` WHERE id=' . $_GET['id'] . ';');
	elseif ($_SESSION['login']!='' && $_GET['id']!='')
		mysqli_query($link,'UPDATE `tasks` SET archive=1 WHERE id=' . $_GET['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/task<?php echo $_GET['return']; ?>.php?id=<?php echo $_GET['job']; ?>"> 
