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
	<h1 style="float: left;">Products
	</h1>
	<span style="float: right;"><a href="product.php"><i class="fa fa-plus" aria-hidden="true"></i> Add a product</a></span><br /><br />
	
	<table class="data">
	<?php
		$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_info`;');
		$info = mysqli_fetch_array($result);
		if ($_GET['archive']=='true') $archive='1'; else $archive='0';
		if ($_GET['q']=='') $archivequery=' WHERE `' . $_SESSION['company'] . '_products`.archive=' . $archive; else $archivequery='';
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='')
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_products`.id,`' . $_SESSION['company'] . '_products`.name,`' . $_SESSION['company'] . '_products`.category,`' . $_SESSION['company'] . '_products`.sku,`' . $_SESSION['company'] . '_products`.price,`' . $_SESSION['company'] . '_products`.added,`' . $_SESSION['company'] . '_products`.archive FROM `' . $_SESSION['company'] . '_products`' . $archivequery . ' ORDER BY id;');
		else
			$result = mysqli_query($link,'SELECT `' . $_SESSION['company'] . '_products`.id,`' . $_SESSION['company'] . '_products`.name,`' . $_SESSION['company'] . '_products`.category,`' . $_SESSION['company'] . '_products`.sku,`' . $_SESSION['company'] . '_products`.price,`' . $_SESSION['company'] . '_products`.added,`' . $_SESSION['company'] . '_products`.archive FROM `' . $_SESSION['company'] . '_products`' . $archivequery . ' ORDER BY `' . $_SESSION['company'] . '_products`.' . $_GET['sort'] . $order . ',id;');
		?>
		<tr><th style="width: 10%;"><a href="products.php?sort=id<?php if ($_GET['sort']=='id' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">ID</a></th><th style="width: 30%;"><a href="products.php?sort=name<?php if ($_GET['sort']=='name' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">PRODUCT NAME</a></th><th style="width: 25%;"><a href="products.php?sort=category<?php if ($_GET['sort']=='category' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">CATEGORY</a></th><th style="width: 20%;"><a href="products.php?sort=sku<?php if ($_GET['sort']=='sku' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">SKU</a></th><th style="width: 15%;"><a href="products.php?sort=price<?php if ($_GET['sort']=='price' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['archive']=='true') echo '&archive=true'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">PRICE</a></th><th></th></th><th></th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==15) {
				$l=0;
				$p++;
			}
			if ($row['archive']==1 && $_GET['archive']!='true') $archivecolor=' style="background: #eeee99 !important;"'; else $archivecolor='';
			if ($_GET['q']=='' || strpos(strtolower($row['id']), strtolower($_GET['q']))!==false || strpos(strtolower($row['name']), strtolower($_GET['q']))!==false || strpos(strtolower($row['category']), strtolower($_GET['q']))!==false || strpos(strtolower($row['sku']), strtolower($_GET['q']))!==false || strpos(strtolower($row['price']), strtolower($_GET['q']))!==false) {				
				echo '<tr' .  $archivecolor . ' class="pages p' . $p . '"><td style="width: 10%;">PR' . sprintf('%04d',$row['id']) . '</td><td style="width: 30%;">';
				echo $row['name'];
				echo '</td><td style="width: 25%;">' . $row['category'] . '</td><td style="width: 20%;">' . $row['sku'] . '</td><td style="width: 15%;">';
				if ($info['currency']=='USD') echo '$'; if ($info['currency']=='EUR') echo '€'; if ($info['currency']=='GBP') echo '£';
				echo number_format($row['price'],2,'.','');
				if ($info['currency']=='PLN') echo ' zł';
				echo '</td><td><a href="productpdf.php?id=' . $row['id'] . '&company=' . $_SESSION['company'] . '&c=' . md5($row['id'] . $_SESSION['company'] . 'PGW') . '" title="Product view"><i class="fa fa-search" aria-hidden="true"></i></a></td><td><a href="productsave.php?id=' . $row['id'] . '&company=' . $_SESSION['company'] . '&c=' . md5($row['id'] . $_SESSION['company'] . 'PGW') . '" title="Product save"><i class="fa fa-save" aria-hidden="true"></i></a></td><td>';
				if ($row['archive']==0) 
					echo '<a href="product.php?id=' . $row['id'] . '" title="Product edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				else
					echo '<a href="productedit.php?id=' . $row['id'] . '" title="Product revive"><i class="fa fa-undo" aria-hidden="true"></i></a>';
				echo '</center></td><td><center><a class="confirm" href="productdel.php?id=' . $row['id'] . '" title="Product archive/delete">';
				if ($row['archive']==1) echo '<i class="fa fa-trash" aria-hidden="true"></i>'; else echo '<i class="fa fa-times" aria-hidden="true"></i>';
				echo '</a></center></td></tr>';
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
	<span><a href="export.php?q=<?php echo $_GET['q']; ?>&sort=<?php echo $_GET['sort']; ?>&archive=<?php echo $_GET['archive']; ?>">Export to CSV</a></span><br />
	<center><?php if ($_GET['archive']!='true') echo '<a href="products.php?archive=true">Archive</a>'; else echo '<a href="products.php">Back</a>'; ?></center>
<?php
	require('template_end.php');
?>
