<?php
/*
 * quote.php
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
			$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_quotes` WHERE id=' . $_GET['id'] . ';');
			$quote = mysqli_fetch_array($result);
		}
?>
	<form action="quoteedit.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $quote['id']; ?>" />
	<table>
	<tr><td>ID noty:<br /><input type="text" name="quoteid" value="<?php if ($quote['quoteid']!='') echo $quote['quoteid']; ?>" /></td>
	<td>Data stworzenia:<br /><div class="field"><?php if ($quote['creation']!='') echo $quote['creation']; else echo date('Y-m-d'); ?>&nbsp;</div></td></tr>
	<?php
$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE id=' . $quote['client'] . ';');
	$client = mysqli_fetch_array($result);
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` ORDER BY company,fullname;');
	?>
	<tr><td>Firma:<br />
	<input type="text" name="clientname" list="clients" onchange="phone(this);" value="<?php 
		if ($client['company']!='') 
			echo $client['company'];
		else
			echo $client['fullname'];
	?>">
	<datalist id="clients">
	<?php
	while ($client = mysqli_fetch_array($result)) {
		if ($client['company']!='') 
			echo '<option>' . $client['company'] . '</option>';
		else
			echo '<option>' . $client['fullname'] . '</option>';
	}
	?>
	</datalist></td>
	<?php 
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE id=' . $quote['client'] . ';');
	$client = mysqli_fetch_array($result);
	?>
	<td>Komórka klienta:<br /><div id="phone" class="field"><?php if ($client['mobile']!='') echo $client['mobile']; ?>&nbsp;</div></td></tr>
	</table><br />
	Krótki opis noty:<br />
	<input type="text" name="name" value="<?php echo $quote['name']; ?>" maxlength="50" /><br /><br />
	Treść:
	<textarea class="desc" name="description"><?php echo $quote['description']; ?></textarea>
	<br /><br />
	<table>
	<tr><td></td><td>Stworzona przez:<br /><div class="field"><?php if ($quote['added']!='') {
		$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_users` WHERE name="' . $quote['added'] . '";');
		$user = mysqli_fetch_array($result);
		echo $quote['added'] . ' - ' . $user['mail']; 
	}
	else {
		$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_users` WHERE name="' . $_SESSION['login'] . '";');
		$user = mysqli_fetch_array($result);
		echo $_SESSION['login'] . ' - ' . $user['mail']; 
	}
	?>&nbsp;</div></td></tr>
	</table><br /><br />
	<input type="submit" value="Zapisz" /><br /><br />
	</form>
<?php
	require('template_end.php');
?>
