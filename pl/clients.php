<?php
/*
 * clientds.php
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
	<h1 style="float: left;">Klienci</h1><span style="float: right;"><a href="client.php"><i class="fa fa-plus" aria-hidden="true"></i> Dodaj klienta</a></span><br /><br />
	<table class="data">
	<?php
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='') 
			$result = mysqli_query($link,'SELECT id,fullname,company,mobile,priority,category,mail FROM `' . $_SESSION['company'] . '_clients` ORDER BY id;');
		else
			$result = mysqli_query($link,'SELECT id,fullname,company,mobile,priority,category,mail FROM `' . $_SESSION['company'] . '_clients` ORDER BY ' . $_GET['sort'] . ',id'. $order . ';');
		?>
        <form action="mailform.php" method="POST">
		<tr><th><input type="checkbox" class="all" name="all" onclick="checkall();" /></th><th style="width: 10%;"><a href="clients.php?sort=id<?php if ($_GET['sort']=='id' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">ID</a></th><th style="width: 20%;"><a href="clients.php?sort=company<?php if ($_GET['sort']=='company' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">FIRMA</a></th><th style="width: 25%;"><a href="clients.php?sort=fullname<?php if ($_GET['sort']=='fullname' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">IMIĘ I NAZWISKO</a></th><th style="width: 20%;"><a href="clients.php?sort=mobile<?php if ($_GET['sort']=='mobile' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">KOMÓRKA</a></th><th><a href="clients.php?sort=category<?php if ($_GET['sort']=='category' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">KATEGORIA</a></th><th><a href="clients.php?sort=priority<?php if ($_GET['sort']=='priority' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">PRI</a></th><th></th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==10) {
				$l=0;
				$p++;
			}
			if ($_GET['q']=='' || strpos(strtolower('CL' . sprintf('%04d',$row['id'])), strtolower($_GET['q']))!==false || strpos(strtolower($row['fullname']), strtolower($_GET['q']))!==false || strpos(strtolower($row['company']), strtolower($_GET['q']))!==false || strpos(strtolower($row['mail']), strtolower($_GET['q']))!==false) {
				echo '<tr class="pages p' . $p . '"><td><input type="checkbox" class="checks" name="emails[]" value="' . $row['mail'] . '" /></td><td style="width: 10%;">CL' . sprintf('%04d',$row['id']) . '</a></td><td style="width: 20%;">' . $row['company'] . '</td><td style="width: 25%;">' . $row['fullname'] . '</td><td style="width: 20%;">' . $row['mobile'];
				echo '</td><td>';
				?>
				<select onchange="client_category(this,<?php echo $row['id']; ?>);">
					<option <?php if ($row['category']=='ACTIVE') echo 'selected'; ?> value="ACTIVE">AKTYWNY</option>
					<option <?php if ($row['category']=='RING') echo 'selected'; ?> value="RING">TELEFON</option>
					<option <?php if ($row['category']=='FREEZE') echo 'selected'; ?> value="FREEZE">ZAMROŻONY</option>
					<option disabled <?php if ($row['category']=='NEW') echo 'selected'; ?> value="NEW">NOWY</option>
				</select>
				</td><td>
				<select onchange="client_priority(this,<?php echo $row['id']; ?>);">
					<option <?php if ($row['priority']=='1') echo 'selected'; ?>>1</option>
					<option <?php if ($row['priority']=='2') echo 'selected'; ?>>2</option>
					<option <?php if ($row['priority']=='3') echo 'selected'; ?>>3</option>
				</select>
				<?php
				echo '</td><td><center><a href="client.php?id=' . $row['id'] . '" title="Edytuj klienta"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></center></td><td><center><a class="confirm" href="clientdel.php?id=' . $row['id'] . '" title="Usuń klienta"><i class="fa fa-trash" aria-hidden="true"></i></a></center></td></tr>';  
				$l++;
			}			
		}
		mysqli_free_result($result);
		mysqli_close($link);
		for ($n=$l;$n<10;$n++) 
			echo '<tr class="pages p' . $p . '"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	?>
	</table><br />
	<center>
	<?php 
	if ($p>1) 
		for ($n=1;$n<=$p;$n++) {
			?><a style="cursor: pointer;" onclick="$('.pages').hide(); $('.p<?php echo $n; ?>').show();"><?php echo $n; ?></a>&nbsp;<?php
		}
	?><br />
	<input type="submit" value="Wyślij e-mail" /></center></form>
<?php
	require('template_end.php');
?>
