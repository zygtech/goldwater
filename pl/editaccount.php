<?php
/*
 * editaccount.php
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
	$query = 'UPDATE `' . $_SESSION['company'] . '_info` SET display="' . $_POST['display'] . '", address="' . $_POST['address'] . '", contact="' . $_POST['contact'] . '", bank="' . $_POST['bank'] . '", color="' . $_POST['color'] . '", currency="' . $_POST['currency'] . '" WHERE id=1;';
	mysqli_query($link,$query);
	$_SESSION['display'] = $_POST['display'];
	move_uploaded_file($_FILES['logo']['tmp_name'], '../logo/' . $_SESSION['company'] . '.png');
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/pl/settings.php" />
