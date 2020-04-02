<?php
/*
 * client.php
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
			$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_products` WHERE id=' . $_GET['id'] . ';');
			$product = mysqli_fetch_array($result);
		}
?>
	<form action="productedit.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $product['id']; ?>" />	
	<table>
	<tr><td>Product ID:<br /><div class="field" style="text-align: center;"><?php if ($product['id']!='') echo 'PR' . sprintf('%04d',$product['id']); else echo 'AUTO'; ?></div></td>
	<td>Date of creation:<br /><div class="field" style="text-align: center;"><?php if ($product['creation']!='') echo $product['creation']; else echo date('Y-m-d'); ?>&nbsp;</div></td></tr>
	<tr><td>Archived<br /><select style="text-align-last: center;" name="archive"><option value="1" <?php if ($product['archive']==1) echo 'selected'; ?>>Archived</option><option value="0" <?php if ($product['archive']==0) echo 'selected'; ?>>Non archived</option></select></td>
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
	?>&nbsp;</div></td></tr>
	<tr><td>Name<br /><input style="text-align: center;" type="text" name="name" value="<?php echo $product['name']; ?>" maxlength="37" /></td>
	<td>Price (brutto)<br /><input id="price" style="text-align: center;" type="text" name="price" maxlength="9" onchange="pricefix(this)" value="<?php if ($product['price']!=0) echo number_format($product['price'],2,'.',''); ?>" /></td></tr>
	<tr><td>VAT<br /><input id="vat" style="text-align: center;" type="text" name="vat" value="<?php if ($product['vat']>0) echo $product['vat']; else echo '23'; ?>" maxlength="3" onchange="pricefix(this)" /></td>
	<td>Price (netto)<br /><div id="netto" class="field" style="text-align: center;"><?php echo number_format(($product['price']*(100/(100+$product['vat']))),2,'.',''); ?>&nbsp;</div></td></tr>	
	<tr><td>SKU<br /><input style="text-align: center;" type="text" name="sku" value="<?php echo $product['sku']; ?>" maxlength="50" /></td>
	<?php
		$result = mysqli_query($link,'SELECT category FROM `' . $_SESSION['company'] . '_products` ORDER BY category;');
		while ($row = mysqli_fetch_array($result))
			if (!in_array($row['category'],$categories))
				$categories[]=$row['category'];
	?>
	<td>Category<br /><input style="text-align: center;" type="text" name="category" list="categories" value="<?php echo $product['category']; ?>" maxlength="50" />
	<datalist id="categories">
	<?php
	foreach ($categories as $category)
		echo '<option>' . $category . '</option>';
	?>
	</datalist>
	</td></tr>

	</table><table>
    <tr><td>Description<br /><textarea name="description" onkeyup="limitTextarea(this,5,100)"><?php echo $product['description']; ?></textarea></td></tr>
	<tr><td><input type="submit" value="Save" /></td></tr>
	</table>
	</form>
<?php
	require('template_end.php');
?>
