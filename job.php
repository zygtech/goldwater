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
	<tr><td>Job ID:<br /><div class="field"><?php if ($job['id']!='') echo 'JB' . sprintf('%04d',$job['id']); ?>&nbsp;</div></td>
	<td>Date of creation:<br /><div class="field"><?php if ($job['creation']!='') echo $job['creation']; else echo date('Y-m-d'); ?>&nbsp;</div></td></tr>
	<?php
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE id=' . $job['client'] . ';');
	$client = mysqli_fetch_array($result);
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` ORDER BY company,fullname;;');
	?>
	<tr><td>Company:<br />
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
	<td>Client mobile:<br /><div class="field" id="phone"><?php if ($client['mobile']!='') echo $client['mobile']; ?>&nbsp;</div></td></tr>
	</table><br />
	Job short description:<br />
	<input type="text" name="name" value="<?php echo $job['name']; ?>" maxlength="50" /><br /><br />
	Job full description:<br />
	<textarea name="description"><?php echo $job['description']; ?></textarea><br /><br />
	<table>
	<tr>
	<td>Stage: <br /><select name="stage">
	<option <?php if ($job['stage']=='1-Proposal') echo 'selected'; ?>>1-Proposal</option>
	<option <?php if ($job['stage']=='2-Valuation') echo 'selected'; ?>>2-Valuation</option>
	<option <?php if ($job['stage']=='3-Waiting') echo 'selected'; ?>>3-Waiting</option>
	<option <?php if ($job['stage']=='4-Project') echo 'selected'; ?>>4-Project</option>
	<option <?php if ($job['stage']=='5-Send to client') echo 'selected'; ?>>5-Send to client</option>
	<option <?php if ($job['stage']=='6-Acceptation') echo 'selected'; ?>>6-Acceptation</option>
	<option <?php if ($job['stage']=='7-Invoice') echo 'selected'; ?>>7-Invoice</option>
	<option <?php if ($job['stage']=='8-Execution') echo 'selected'; ?>>8-Execution</option>
	<option disabled <?php if ($job['stage']=='9-Finished') echo 'selected'; ?>>9-Finished</option>
	</select></td>
	<td>Created by:<br /><div class="field"><?php if ($job['added']!='') {
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
	Additional info:<br />
	<textarea name="info" onkeyup="limitTextarea(this,5,100)"><?php echo $job['info']; ?></textarea><br /><br />
	<table>
	<tr><td>Required by: <br /><input type="date" name="required" value="<?php echo $job['required']; ?>" /></td>
	<td>Finished on:<br /><div class="field"><?php echo $job['finished']; ?>&nbsp;</div></td></tr>
	</table><br />
	<input type="submit" value="Save" /><br /><br />
	</form>
<?php
	require('template_end.php');
?>
