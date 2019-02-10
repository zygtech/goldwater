<?php
/*
 * jobs.php
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
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
?>
	<h1 style="float: left;">Jobs</h1><span style="float: right;"><a href="job.php"><i class="fa fa-plus" aria-hidden="true"></i> Add a job</a></span><br /><br />
	<table class="data">
	<?php
		if ($_GET['archive']=='true') $archive='1'; else $archive='0';
		if ($_GET['q']=='') $archivequery=' WHERE `' . $_SESSION['company'] . '_jobs`.archive=' . $archive; else $archivequery='';
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='')
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_jobs`.id,`' . $_SESSION['company'] . '_jobs`.name,`' . $_SESSION['company'] . '_jobs`.client,`' . $_SESSION['company'] . '_jobs`.required,`' . $_SESSION['company'] . '_jobs`.stage,`' . $_SESSION['company'] . '_jobs`.finished,`' . $_SESSION['company'] . '_jobs`.priority,`' . $_SESSION['company'] . '_jobs`.archive,`' . $_SESSION['company'] . '_clients`.fullname,`' . $_SESSION['company'] . '_clients`.company FROM `' . $_SESSION['company'] . '_jobs` INNER JOIN `' . $_SESSION['company'] . '_clients` ON `' . $_SESSION['company'] . '_jobs`.client = `' . $_SESSION['company'] . '_clients`.id' . $archivequery . ' ORDER BY id;');
		else
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_jobs`.id,`' . $_SESSION['company'] . '_jobs`.name,`' . $_SESSION['company'] . '_jobs`.client,`' . $_SESSION['company'] . '_jobs`.required,`' . $_SESSION['company'] . '_jobs`.stage,`' . $_SESSION['company'] . '_jobs`.finished,`' . $_SESSION['company'] . '_jobs`.priority,`' . $_SESSION['company'] . '_jobs`.archive,`' . $_SESSION['company'] . '_clients`.fullname,`' . $_SESSION['company'] . '_clients`.company FROM `' . $_SESSION['company'] . '_jobs` INNER JOIN `' . $_SESSION['company'] . '_clients` ON `' . $_SESSION['company'] . '_jobs`.client = `' . $_SESSION['company'] . '_clients`.id' . $archivequery . ' ORDER BY ' . $_GET['sort'] . ',id'. $order . ';');
		?>
		<tr><th style="width: 7%"><a href="jobs.php?sort=id<?php if ($_GET['sort']=='id' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">JOB ID</a></th><th style="width: 20%;"><a href="jobs.php?sort=company<?php if ($_GET['sort']=='company' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">CLIENT</a></th><th style="width: 30%;"><a href="jobs.php?sort=name<?php if ($_GET['sort']=='name' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">JOB NAME</a></th><th style="width: 15%;"><a href="jobs.php?sort=required<?php if ($_GET['sort']=='required' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">REQUIRED BY</a></th><th style="width: 15%;"><a href="jobs.php?sort=stage<?php if ($_GET['sort']=='stage' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">STAGE</a></th><th><a href="jobs.php?sort=priority<?php if ($_GET['sort']=='priority' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">PRI</a></th><th></th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==10) {
				$l=0;
				$p++;
			}
			if ($row['archive']==1 && $_GET['archive']!='true') $archivecolor=' style="background: #eeee99 !important;"'; else $archivecolor='';
			if ($_GET['q']=='' || strpos(strtolower('JB' . sprintf('%04d',$row['id'])), strtolower($_GET['q']))!==false || strpos(strtolower($row['name']), strtolower($_GET['q']))!==false || strpos(strtolower($row['company']), strtolower($_GET['q']))!==false || strpos(strtolower($row['fullname']), strtolower($_GET['q']))!==false) {				
				echo '<tr' .  $archivecolor . ' class="pages p' . $p . '"><td style="width: 7%;">JB' . sprintf('%04d',$row['id']) . '</td><td style="width: 20%;">';
				if ($row['company']!='') echo $row['company']; else echo $row['fullname'];
				echo ' <a href="client.php?id=' . $row['client'] . '" style="background: none; color: #58585a;" title="Client edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td><td style="width: 30%;">' . $row['name'] . '</td><td style="width: 15%;">' . $row['required'] . '</td><td id="F' . $row['id'] . '" style="width: 15%;">';
				if ($row['archive']==0) {?>
				<select onchange="job_stage(this,<?php echo $row['id']; ?>);">
					<option <?php if ($row['stage']=='1-Proposal') echo 'selected'; ?>>1-Proposal</option>
					<option <?php if ($row['stage']=='2-Valuation') echo 'selected'; ?>>2-Valuation</option>
					<option <?php if ($row['stage']=='3-Waiting') echo 'selected'; ?>>3-Waiting</option>
					<option <?php if ($row['stage']=='4-Project') echo 'selected'; ?>>4-Project</option>
					<option <?php if ($row['stage']=='5-Send to client') echo 'selected'; ?>>5-Send to client</option>
					<option <?php if ($row['stage']=='6-Acceptation') echo 'selected'; ?>>6-Acceptation</option>
					<option <?php if ($row['stage']=='7-Invoice') echo 'selected'; ?>>7-Invoice</option>
					<option <?php if ($row['stage']=='8-Execution') echo 'selected'; ?>>8-Execution</option>
					<option disabled <?php if ($row['stage']=='9-Finished') echo 'selected'; ?>>9-Finished</option>
				</select>
				<?php }
				else echo $row['finished'];
				echo '</td><td>';
				?>
				<select onchange="job_priority(this,<?php echo $row['id']; ?>);">
					<option <?php if ($row['priority']=='1') echo 'selected'; ?>>1</option>
					<option <?php if ($row['priority']=='2') echo 'selected'; ?>>2</option>
					<option <?php if ($row['priority']=='3') echo 'selected'; ?>>3</option>
				</select>
				<?php
				echo '</td><td><center><a href="task.php?id=' . $row['id'] . '" title="Add tasks"><i class="fa fa-tasks" aria-hidden="true"></i></a></center></td><td><center>';
				if ($row['archive']==0)
					echo '<a href="job.php?id=' . $row['id'] . '" title="Job edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				else
					echo '<a href="jobedit.php?id=' . $row['id'] . '" title="Job revive"><i class="fa fa-undo" aria-hidden="true"></i></a>';				
				echo '</center></td><td><center><a class="confirm" href="jobdel.php?id=' . $row['id'] . '" title="Job tick/delete">';
				if ($row['archive']==1) echo '<i class="fa fa-trash" aria-hidden="true"></i>'; else echo '<i class="fa fa-check" aria-hidden="true"></i>';
				echo '</a></center></td></tr>';
				$l++;
			}
		}
		mysqli_free_result($result);
		mysqli_close($link);
		for ($n=$l;$n<10;$n++) 
			echo '<tr class="pages p' . $p . '"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	?>
	</table><br /><center>	
	<?php 
	if ($p>1) 
		for ($n=1;$n<=$p;$n++) {
			?><a style="cursor: pointer;" onclick="$('.pages').hide(); $('.p<?php echo $n; ?>').show();"><?php echo $n; ?></a>&nbsp;<?php
		}
	?></center><br />
	<center><?php if ($_GET['archive']!='true') echo '<a href="jobs.php?archive=true">Archive</a>'; else echo '<a href="jobs.php">Back</a>'; ?></center>
<?php
	require('template_end.php');
?>
