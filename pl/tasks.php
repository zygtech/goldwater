<?php
/*
 * tasks.php
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
		$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_tasks`.id,`' . $_SESSION['company'] . '_tasks`.job,`' . $_SESSION['company'] . '_tasks`.name,`' . $_SESSION['company'] . '_tasks`.archive,`' . $_SESSION['company'] . '_tasks`.added,`' . $_SESSION['company'] . '_jobs`.id AS jobid,`' . $_SESSION['company'] . '_jobs`.name AS jobname FROM `' . $_SESSION['company'] . '_tasks` INNER JOIN `' . $_SESSION['company'] . '_jobs` ON `' . $_SESSION['company'] . '_jobs`.id=`' . $_SESSION['company'] . '_tasks`.job WHERE `' . $_SESSION['company'] . '_tasks`.added="' . $_SESSION['login'] . '"' . $archivequery . ' ORDER BY id DESC;');
		?>
		<tr><th style="width: 24%;">ZLECENIE</th><th style="width: 70%;">ZADANIE</th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==10) {
				$l=0;
				$p++;
			}
			if ($row['archive']==1 && $_GET['archive']!='true') $archivecolor=' style="background: #eeee99 !important;"'; else $archivecolor='';
			if ($_GET['q']=='' || strpos(strtolower($row['name']), strtolower($_GET['q']))!==false) {				
				echo '<tr' .  $archivecolor . ' class="pages p' . $p . '"><td style="width: 24%;">' . $row['jobname'] . '</td><td style="width: 70%;">' . $row['name'] . '</td>';
				if ($row['archive']==0)
					echo '<td style="width: 3%;"></td><td style="width: 3%;">';
				else
					echo '<td style="width: 3%;"><a href="taskedit.php?id=' . $row['id'] . '&job=' . $row['jobid'] . '&return=s" title="Odnów zadanie"><i class="fa fa-undo" aria-hidden="true"></i></a></td><td style="width: 3%;">';	
				echo ' <a class="confirm" href="taskdel.php?id=' . $row['id'] . '&job=' . $row['jobid'] . '&return=s" title="Zakończ/Usuń zadanie">';
				if ($row['archive']==1) echo '<i class="fa fa-trash" aria-hidden="true"></i>'; else echo '<i class="fa fa-check" aria-hidden="true"></i>';
				echo '</a></td></tr>';
			$l++;
			}
		}
		mysqli_free_result($result);
		mysqli_close($link);
		for ($n=$l;$n<10;$n++) 
			echo '<tr class="pages p' . $p . '"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	?>
	</table><br /><center>	
	<?php 
	if ($p>1) 
		for ($n=1;$n<=$p;$n++) {
			?><a style="cursor: pointer;" onclick="$('.pages').hide(); $('.p<?php echo $n; ?>').show();"><?php echo $n; ?></a>&nbsp;<?php
		}
	?></center><br />
	<center><?php if ($_GET['archive']!='true') echo '<a href="tasks.php?archive=true&id=' . $_GET['id'] . '">Archiwum</a>'; else echo '<a href="tasks.php?id=' . $_GET['id'] . '">Wstecz</a>'; ?></center>
<?php
	require('template_end.php');
?>

