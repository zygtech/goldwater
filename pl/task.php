<?php
/*
 * task.php
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
?>
	<h1 style="float: left;">Zadania</h1><br /><br />
	<table class="data">
	<?php
		if ($_GET['archive']=='true') $archive='1'; else $archive='0';
		if ($_GET['q']=='') $archivequery=' AND `' . $_SESSION['company'] . '_tasks`.archive=' . $archive; else $archivequery='';
		if ($_GET['order']=='DESC') $order=' DESC';
		$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_tasks`.id,`' . $_SESSION['company'] . '_tasks`.job,`' . $_SESSION['company'] . '_tasks`.name,`' . $_SESSION['company'] . '_tasks`.archive,`' . $_SESSION['company'] . '_tasks`.added FROM `' . $_SESSION['company'] . '_tasks` WHERE `' . $_SESSION['company'] . '_tasks`.job=' . $_GET['id'] . $archivequery . ' ORDER BY id DESC;');

		?>
		<tr><th style="width: 62%;">ZADANIE</th><th style="width: 30%;">UŻYTKOWNIK</th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==10) {
				$l=0;
				$p++;
			}
			if ($row['archive']==1 && $_GET['archive']!='true') $archivecolor=' style="background: #eeee99 !important;"'; else $archivecolor='';
			if ($_GET['q']=='' || strpos(strtolower($row['name']), strtolower($_GET['q']))!==false) {				
				echo '<tr' .  $archivecolor . ' class="pages p' . $p . '"><td style="width: 64%;">' . $row['name'] . '</td><td style="width: 30%;">' . $row['added'] . '</td>';
				if ($row['archive']==0)
					echo '<td style="width: 3%;"></td><td style="width: 3%;">';
				else
					echo '<td style="width: 3%;"><a href="taskedit.php?id=' . $row['id'] . '&job=' . $_GET['id'] . '" title="Task revive"><i class="fa fa-undo" aria-hidden="true"></i></a></td><td style="width: 3%;">';	
				echo ' <a class="confirm" href="taskdel.php?id=' . $row['id'] . '&job=' . $_GET['id'] . '" title="Task tick/delete">';
				if ($row['archive']==1) echo '<i class="fa fa-trash" aria-hidden="true"></i>'; else echo '<i class="fa fa-check" aria-hidden="true"></i>';
				echo '</a></td></tr>';
				$l++;
			}
		}
		mysqli_free_result($result);
		for ($n=$l;$n<10;$n++) 
			echo '<tr class="pages p' . $p . '"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	if ($_GET['archive']!='true' && $_GET['q']=='') {
	?>
	<form action="taskedit.php" method="post">
	<input type="hidden" name="job" value="<?php echo $_GET['id']; ?>" />
	<tr style="display: table-row;"><td style="border-top: 2px solid white; background: white;"><input type="text" name="name" maxlength="50" value="" /></td><td style="border-top: 2px solid white; background: white;  text-align: center;"><select name="user">
	<?php
	$result = mysqli_query($link,'SELECT * FROM ' . $_SESSION['company'] . '_users;');
	while ($row = mysqli_fetch_array($result)) {
		echo '<option value="' . $row['name'] . '">' . $row['name'] . ' (' . $row['mail'] . ')</option>';
	}
	mysqli_free_result($result);
	?>
	</select></td><td style="border-top: 2px solid white; background: white;"><center><input type="submit" value="+"</center></td></tr>
	</form>
	<?php } ?>
	</table><br /><center>	
	<?php 
	if ($p>1) 
		for ($n=1;$n<=$p;$n++) {
			?><a style="cursor: pointer;" onclick="$('.pages').hide(); $('.p<?php echo $n; ?>').show();"><?php echo $n; ?></a>&nbsp;<?php
		}
	?></center><br />
	<center><?php if ($_GET['archive']!='true') echo '<a href="task.php?archive=true&id=' . $_GET['id'] . '">Archiwum</a>'; else echo '<a href="task.php?id=' . $_GET['id'] . '">Wstecz</a>'; ?></center>
<?php
	require('template_end.php');
?>
