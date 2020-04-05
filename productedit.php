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
	if ($_POST['id']=='') {
		mysqli_query($link,'INSERT INTO `' . $_SESSION['company'] . '_products` VALUES (0,"' . strip_tags($_POST['name']) . '",' . $_POST['price'] . ',' . $_POST['vat'] . ',"' . strip_tags($_POST['category']) . '","' . strip_tags($_POST['description']) . '","' . strip_tags($_POST['sku']) . '",NOW(),"' . strip_tags($_SESSION['login']) . '",0);');
		$id = mysqli_insert_id($link);
	}
	elseif (strip_tags($_POST['name'])!='') {
		mysqli_query($link,'UPDATE `' . $_SESSION['company'] . '_products` SET name="' . strip_tags($_POST['name']) . '", price=' . $_POST['price'] . ', vat=' . $_POST['vat'] . ', category="' . strip_tags($_POST['category']) . '", description="' . strip_tags($_POST['description']) . '", sku="' . strip_tags($_POST['sku']) . '" WHERE id=' . $_POST['id'] . ';');
		$id = $_POST['id'];
	}
	if ($_GET['id']!='' && $_SESSION['login']!='')
		mysqli_query($link,'UPDATE `' . $_SESSION['company'] . '_products` SET archive=0 WHERE id=' . $_GET['id'] . ';');
	mysqli_free_result($result);
	mysqli_close($link);
	if ($_FILES['photo']['tmp_name']!='')
		move_uploaded_file($_FILES['photo']['tmp_name'],'products/' . $_SESSION['company'] . '_PR' . sprintf('%04d',$id));
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/products.php">
