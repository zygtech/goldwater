<?php
/*
 * invoice.php
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
		$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_info`;');
		$info = mysqli_fetch_array($result);
		if ($_GET['id']!='') {
			$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_invoices` WHERE id=' . $_GET['id'] . ';');
			$invoice = mysqli_fetch_array($result);
		}
?>
	<form action="invoiceedit.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $invoice['id']; ?>" />
	<table>
	<tr><td>ID faktury:<br /><input type="text" name="invoiceid" value="<?php if ($invoice['invoiceid']!='') echo $invoice['invoiceid']; ?>" /></td>
	<td>Data stworzenia:<br /><div class="field"><?php if ($invoice['creation']!='') echo $invoice['creation']; else echo date('Y-m-d'); ?>&nbsp;</div></td></tr>
	<?php
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE id=' . $invoice['client'] . ';');
	$client = mysqli_fetch_array($result);
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` ORDER BY company,fullname;');
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
	$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_clients` WHERE id=' . $invoice['client'] . ';');
	$client = mysqli_fetch_array($result);
	?>
	<td>Komórka klienta:<br /><div id="phone" class="field"><?php if ($client['mobile']!='') echo $client['mobile']; ?>&nbsp;</div></td></tr>
	</table><?php
	$description = explode("\n", $invoice['description']);
	$type = explode("\n", $invoice['type']);
	$brutto = explode("\n", $invoice['brutto']);
	$vat = explode("\n", $invoice['vat']);
	?>
	<table><tr><td style="width: 5% !important;">Lp.</td><td style="width: 40% !important;">Opis</td><td style="width: 15% !important;">Rodzaj</td>
	<td style="width: 10% !important;">Brutto</td><td style="width: 10% !important;">VAT (%)</td><td style="width: 10% !important;">VAT</td><td style="width: 10% !important;">Netto</td></tr>
	<?php for($i=0;$i<15;$i++) {
	?><tr id="row<?php echo $i; ?>" class="row" style="<?php if ($i==0 || $description[$i-1]!='') echo 'display: table-row;'; ?>"><td style="width: 5% !important;"><input disabled class="desc" type="text" id="lp<?php echo $i; ?>" name="id<?php echo $i; ?>" value="<?php if ($description[$i]!='') echo $i+1; ?>" /></td><td style="width: 40% !important;"><input class="desc" type="text" list="products" name="description<?php echo $i; ?>" maxlength="255" onchange="additem(this,<?php echo $i; ?>)" value="<?php echo $description[$i]; ?>" />
	<datalist id="products">
	<?php
		if ($invoice['currency']!='') $currency=$invoice['currency']; else $currency=$info['currency'];
		$result = mysqli_query($link,'SELECT id,name,price,vat,sku FROM `' . $_SESSION['company'] . '_products` WHERE archive=0 ORDER BY id;');
		while ($product = mysqli_fetch_array($result)) 
			echo '<option>' . $product['name'] . ' : ' . $product['price'] . $currency . ' : ' . $product['vat'] . '% VAT : ' . $product['sku'] . '</option>';
	?>
	</datalist>
	</td><td style="width: 15% !important;"><input class="desc" id="type<?php echo $i; ?>" <?php if ($description[$i]=='') echo 'disabled="disabled"'; ?> type="text" name="type<?php echo $i; ?>" list="types" maxlength="10" value="<?php echo $type[$i]; ?>" /><datalist id="types"><option>Service</option><option>Product</option></datalist></td>
	<td style="width: 10% !important;"><input class="desc" type="text" name="brutto<?php echo $i; ?>" id="brutto<?php echo $i; ?>" <?php if ($description[$i]=='') echo 'disabled="disabled"'; ?> maxlength="9" onchange="calcvat(this,<?php echo $i; ?>);" value="<?php if ($brutto[$i]!=0) echo number_format($brutto[$i],2,'.',''); ?>" /></td><td style="width: 10% !important;"><input class="desc" type="text" name="vat<?php echo $i; ?>" id="vat<?php echo $i; ?>" <?php if ($description[$i]=='') echo 'disabled="disabled"'; ?> maxlength="2" onchange="calcvat(this,<?php echo $i; ?>);" value="<?php if ($vat[$i]!=0) echo $vat[$i]; ?>" /></td><td style="width: 10% !important;"><div id="vatvalue<?php echo $i; ?>" class="field"><?php if ($brutto[$i]!=0) echo number_format(($brutto[$i]-($brutto[$i]*100/(100+$vat[$i]))),2,'.',''); else echo '&nbsp;'; ?></div></td><td style="width: 10% !important;"><div id="netto<?php echo $i; ?>" class="field"><?php if ($brutto[$i]!=0) echo number_format(($brutto[$i]*100/(100+$vat[$i])),2,'.',''); else echo '&nbsp;'; ?></div></td></tr>
	<?php } ?>
	</table>
	<table><tr><th>Bank</th><th>Waluta</th></tr>
	<tr><td rowspan="3"><textarea style="width: 90%;" name="bank" id="bank" onkeyup="limitTextarea(this,3,50)"><?php if ($invoice['bank']=='') echo $info['bank']; else echo $invoice['bank']; ?></textarea></td>
	<td><select class="desc" name="currency" id="currency">
	<option <?php if ($currency=='USD') echo 'selected'; ?>>USD</option>
	<option <?php if ($currency=='EUR') echo 'selected'; ?>>EUR</option>
	<option <?php if ($currency=='GBP') echo 'selected'; ?>>GBP</option>
	<option <?php if ($currency=='PLN') echo 'selected'; ?>>PLN</option>
	</select></td></tr><tr><th>Razem</th></tr><tr><td><div id="total" class="field"><?php echo number_format($invoice['total'],2,'.',''); ?>
	</div></td></tr></table>
	<table><tr><th>Dodatkowe info:</th></tr><tr><td><input type="text" name="info" value="<?php echo $invoice['info']; ?>" /></td></tr></table>
	<table>
	<tr><td></td><td>Stworzona przez:<br /><div class="field"><?php if ($invoice['added']!='') {
		$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_users` WHERE name="' . $invoice['added'] . '";');
		$user = mysqli_fetch_array($result);
		echo $invoice['added'] . ' - ' . $user['mail']; 
	}
	else {
		$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_users` WHERE name="' . $_SESSION['login'] . '";');
		$user = mysqli_fetch_array($result);
		echo $_SESSION['login'] . ' - ' . $user['mail']; 
	}
	?>&nbsp;</div></td></tr>
	</table><br /><br />
	<input type="submit" value="Zapisz" /><br /><br />
	</form>
<?php
	require('template_end.php');
?>

