<?php
/*
 * invoices.php
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
	<h1 style="float: left;">Faktury</h1><span style="float: right;"><a href="invoice.php"><i class="fa fa-plus" aria-hidden="true"></i> Dodaj fakturę</a></span><br /><br />
	<table class="data">
	<?php
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='')
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_invoices`.id,`' . $_SESSION['company'] . '_invoices`.invoiceid,`' . $_SESSION['company'] . '_invoices`.currency,`' . $_SESSION['company'] . '_invoices`.client,`' . $_SESSION['company'] . '_invoices`.total,`' . $_SESSION['company'] . '_invoices`.added,`' . $_SESSION['company'] . '_invoices`.creation,`' . $_SESSION['company'] . '_clients`.fullname,`' . $_SESSION['company'] . '_clients`.company FROM `' . $_SESSION['company'] . '_invoices` INNER JOIN `' . $_SESSION['company'] . '_clients` ON `' . $_SESSION['company'] . '_invoices`.client = `' . $_SESSION['company'] . '_clients`.id ORDER BY invoiceid,id;');
		else
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_invoices`.id,`' . $_SESSION['company'] . '_invoices`.invoiceid,`' . $_SESSION['company'] . '_invoices`.currency,`' . $_SESSION['company'] . '_invoices`.client,`' . $_SESSION['company'] . '_invoices`.total,`' . $_SESSION['company'] . '_invoices`.added,`' . $_SESSION['company'] . '_invoices`.creation,`' . $_SESSION['company'] . '_clients`.fullname,`' . $_SESSION['company'] . '_clients`.company FROM `' . $_SESSION['company'] . '_invoices` INNER JOIN `' . $_SESSION['company'] . '_clients` ON `' . $_SESSION['company'] . '_invoices`.client = `' . $_SESSION['company'] . '_clients`.id ORDER BY ' . $_GET['sort'] . $order . ',invoiceid,id;');
		?>
		<tr><th style="width: 20%;"><a href="invoices.php?sort=invoiceid<?php if ($_GET['sort']=='invoiceid' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">ID</a></th><th style="width: 30%;"><a href="invoices.php?sort=company<?php if ($_GET['sort']=='company' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">KLIENT</a></th><th style="width: 15%;"><a href="invoices.php?sort=added<?php if ($_GET['sort']=='added' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">PRZEZ</a></th><th style="width: 15%;"><a href="invoices.php?sort=creation<?php if ($_GET['sort']=='creation' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">DATA</a></th><th style="width: 20%;"><a href="invoices.php?sort=total<?php if ($_GET['sort']=='total' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">RAZEM</a></th><th></th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==15) {
				$l=0;
				$p++;
			}
			if ($_GET['q']=='' || strpos(strtolower($row['invoiceid']), strtolower($_GET['q']))!==false || strpos(strtolower($row['company']), strtolower($_GET['q']))!==false || strpos(strtolower($row['fullname']), strtolower($_GET['q']))!==false || strpos(strtolower($row['creation']), strtolower($_GET['q']))!==false || strpos(strtolower($row['total']), strtolower($_GET['q']))!==false) {				
				echo '<tr class="pages p' . $p . '"><td style="width: 20%;">' . $row['invoiceid'] . '</td><td style="width: 30%;">';
				if ($row['company']!='') echo $row['company']; else echo $row['fullname'];
				echo ' <a href="client.php?id=' . $row['client'] . '" style="background: none; color: #58585a;" title="Edytuj klienta"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td><td style="width: 15%;">' . $row['added'] . '</td><td style="width: 15%;">' . $row['creation'] . '</td><td style="width: 20%;">';
				if ($row['currency']=='USD') echo '$'; if ($row['currency']=='EUR') echo '€'; if ($row['currency']=='GBP') echo '£';
				echo number_format($row['total'],2,'.','');
				if ($row['currency']=='PLN') echo ' zł';
				echo '</td><td><a href="invoicepdf.php?id=' . $row['id'] . '&company=' . $_SESSION['company'] . '&c=' . md5($row['id'] . $_SESSION['company'] . 'IGW') . '" title="Obejrzyj fakturę"><i class="fa fa-search" aria-hidden="true"></i></a></td><td><a href="invoicesave.php?id=' . $row['id'] . '&company=' . $_SESSION['company'] . '&c=' . md5($row['id'] . $_SESSION['company'] . 'IGW') . '" title="Zapisz fakturę"><i class="fa fa-save" aria-hidden="true"></i></a></td><td><a href="invoice.php?id=' . $row['id'] . '" title="Edytuj fakturę"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td><td><a class="confirm" href="invoicedel.php?id=' . $row['id'] . '" title="Usuń fakturę"><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>';
				$l++;
			}
		}
		mysqli_free_result($result);
		mysqli_close($link);
		for ($n=$l;$n<15;$n++) 
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
	echo '<br /><a href="iexport.php?q=' . $_GET['q'] . '&sort=' . $_GET['sort'] . '&order=' . $_GET['order'] . '" target="_BLANK">Eksport do CSV</a>';
	require('template_end.php');
?>
