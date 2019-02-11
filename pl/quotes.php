<?php
/*
 * quotes.php
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
	<h1 style="float: left;">Noty</h1><span style="float: right;"><a href="quote.php"><i class="fa fa-plus" aria-hidden="true"></i> Dodaj notę</a></span><br /><br />
	<table class="data">
	<?php
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='')
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_quotes`.id,`' . $_SESSION['company'] . '_quotes`.name,`' . $_SESSION['company'] . '_quotes`.added,`' . $_SESSION['company'] . '_quotes`.quoteid,`' . $_SESSION['company'] . '_quotes`.creation,`' . $_SESSION['company'] . '_quotes`.client,`' . $_SESSION['company'] . '_clients`.fullname,`' . $_SESSION['company'] . '_clients`.company FROM `' . $_SESSION['company'] . '_quotes` INNER JOIN `' . $_SESSION['company'] . '_clients` ON `' . $_SESSION['company'] . '_quotes`.client = `' . $_SESSION['company'] . '_clients`.id ORDER BY quoteid,id;');
		else
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_quotes`.id,`' . $_SESSION['company'] . '_quotes`.name,`' . $_SESSION['company'] . '_quotes`.added,`' . $_SESSION['company'] . '_quotes`.quoteid,`' . $_SESSION['company'] . '_quotes`.creation,`' . $_SESSION['company'] . '_quotes`.client,`' . $_SESSION['company'] . '_clients`.fullname,`' . $_SESSION['company'] . '_clients`.company FROM `' . $_SESSION['company'] . '_quotes` INNER JOIN `' . $_SESSION['company'] . '_clients` ON `' . $_SESSION['company'] . '_quotes`.client = `' . $_SESSION['company'] . '_clients`.id ORDER BY ' . $_GET['sort'] . $order . ',quoteid,id;');
		?>
			<tr><th style="width: 20%;"><a href="quotes.php?sort=quoteid<?php if ($_GET['sort']=='quoteid' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">ID</a></th><th style="width: 30%;"><a href="quotes.php?sort=name<?php if ($_GET['sort']=='name' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">NAZWA NOTY</a></th><th style="width: 15%;"><a href="quotes.php?sort=added<?php if ($_GET['sort']=='added' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">PRZEZ</a></th><th style="width: 23%;"><a href="quotes.php?sort=company<?php if ($_GET['sort']=='company' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">KLIENT</a></th><th style="width: 15%;"><a href="quotes.php?sort=creation<?php if ($_GET['sort']=='creation' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">DATA</a></th><th></th><th></th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==10) {
				$l=0;
				$p++;
			}
			if ($_GET['q']=='' || strpos(strtolower($row['quoteid']), strtolower($_GET['q']))!==false || strpos(strtolower($row['name']), strtolower($_GET['q']))!==false || strpos(strtolower($row['company']), strtolower($_GET['q']))!==false || strpos(strtolower($row['fullname']), strtolower($_GET['q']))!==false || strpos(strtolower($row['creation']), strtolower($_GET['q']))!==false) {				
				echo '<tr class="pages p' . $p . '"><td style="width: 20%;">' . $row['quoteid'] . '</td><td style="width: 30%;">' . $row['name'] . '</td><td style="width: 15%;">' . $row['added'] . '</td><td style="width: 23%;">';
				if ($row['company']!='') echo $row['company']; else echo $row['fullname'];
				echo ' <a href="client.php?id=' . $row['client'] . '" style="background: none; color: #58585a;" title="Edytuj klienta"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td><td style="width: 15%;">' . $row['creation'] . '</td><td><a href="quotepdf.php?id=' . $row['id'] . '&company=' . $_SESSION['company'] . '" title="Obejrzyj notę"><i class="fa fa-search" aria-hidden="true"></i></a></td><td><a href="quotesave.php?id=' . $row['id'] . '&company=' . $_SESSION['company'] . '" title="Zapisz notę"><i class="fa fa-save" aria-hidden="true"></i></a></td><td><a href="quote.php?id=' . $row['id'] . '" title="Edytuj notę"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td><td><a class="confirm" href="quotedel.php?id=' . $row['id'] . '" title="Usuń notę"><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>';
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
	?></center>
<?php
	require('template_end.php');
?>
