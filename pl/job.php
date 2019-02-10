<?php
/*
 * job.php
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
			$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_jobs` WHERE id=' . $_GET['id'] . ';');
			$job = mysqli_fetch_array($result);
		}
		?>
	<form action="jobedit.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $job['id']; ?>" />
	<table>
	<tr><td>ID zlecenia:<br /><div class="field"><?php if ($job['id']!='') echo 'JB' . sprintf('%04d',$job['id']); ?>&nbsp;</div></td>
	<td>Data stworzenia:<br /><div class="field"><?php if ($job['creation']!='') echo $job['creation']; else echo date('Y-m-d'); ?>&nbsp;</div></td></tr>
	<?php
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE id=' . $job['client'] . ';');
	$client = mysqli_fetch_array($result);
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` ORDER BY company,fullname;;');
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
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE id=' . $job['client'] . ';');
	$client = mysqli_fetch_array($result);
	?>
	<td>Komórka klienta:<br /><div class="field" id="phone"><?php if ($client['mobile']!='') echo $client['mobile']; ?>&nbsp;</div></td></tr>
	</table><br />
	Krótki opis zlecenia:<br />
	<input type="text" name="name" value="<?php echo $job['name']; ?>" maxlength="50" /><br /><br />
	Pełny opis zlecenia:<br />
	<textarea name="description"><?php echo $job['description']; ?></textarea><br /><br />
	<table>
	<tr>
	<td>Etap: <br /><select name="stage">
	<option <?php if ($job['stage']=='1-Proposal') echo 'selected'; ?> value="1-Proposal">1-Propozycja</option>
	<option <?php if ($job['stage']=='2-Valuation') echo 'selected'; ?> value="2-Valuation">2-Oszacowanie</option>
	<option <?php if ($job['stage']=='3-Waiting') echo 'selected'; ?> value="3-Waiting">3-Oczekiwanie</option>
	<option <?php if ($job['stage']=='4-Project') echo 'selected'; ?> value="4-Project">4-Projekt</option>
	<option <?php if ($job['stage']=='5-Send to client') echo 'selected'; ?> value="5-Send to client">5-Wysłano klientowi</option>
	<option <?php if ($job['stage']=='6-Acceptation') echo 'selected'; ?> value="6-Acceptation">6-Akceptacja</option>
	<option <?php if ($job['stage']=='7-Invoice') echo 'selected'; ?> value="7-Invoice">7-Faktura</option>
	<option <?php if ($job['stage']=='8-Execution') echo 'selected'; ?> value="8-Execution">8-Wykonanie</option>
	<option disabled <?php if ($job['stage']=='9-Finished') echo 'selected'; ?> value="9-Finished">9-Zakończono</option>
	</select></td>
	<td>Stworzone przez:<br /><div class="field"><?php if ($job['added']!='') {
		$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_users` WHERE name="' . $job['added'] . '";');
		$user = mysqli_fetch_array($result);
		echo $job['added'] . ' - ' . $user['mail']; 
	}
	else {
		$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_users` WHERE name="' . $_SESSION['login'] . '";');
		$user = mysqli_fetch_array($result);
		echo $_SESSION['login'] . ' - ' . $user['mail']; 
	}
	?>&nbsp;</div></td></tr></table><br />
	Dodatkowe informacje:<br />
	<textarea name="info" onkeyup="limitTextarea(this,5,100)"><?php echo $job['info']; ?></textarea><br /><br />
	<table>
	<tr><td>Termin: <br /><input type="date" name="required" value="<?php echo $job['required']; ?>" /></td>
	<td>Zakończono:<br /><div class="field"><?php echo $job['finished']; ?>&nbsp;</div></td></tr>
	</table><br />
	<input type="submit" value="Zapisz" /><br /><br />
	</form>
<?php
	require('template_end.php');
?>
