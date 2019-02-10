<?php
/*
 * mailform.php
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
	require('template_begin.php');
		if ($_GET['id']!='') {
			$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE id=' . $_GET['id'] . ';');
			$client = mysqli_fetch_array($result);
		}
?>
	<form action="mailsend.php" method="POST">
	Temat:<br />
	<input type="text" name="title" /><br /><br />
	Treść:<br />
	<textarea style="height: 250px;" name="content"></textarea>
	<br /><br />
	<?php
	foreach ($_POST['emails'] as $email)
		echo $email . '<br /><input type="hidden" name="emails[]" value="' . $email . '" />';
	?>
	<br />
	<input type="submit" value="Wyślij" />
	</form>
<?php
	require('template_end.php');
?>
