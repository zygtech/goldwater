<?php
/*
 * settings.php
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
		mysqli_free_result($result);
?>
<h1>Settings</h1>
<h2>User</h2>
<form action="adduser.php" method="POST">
<div id="box">
<table>
<tr><td>LOGIN:</td><td><input type="text" name="login" pattern="[A-Za-z0-9\S]{1,20}" /></td></tr>
<tr><td>PASSWORD:</td><td><input type="password" name="pass" /></td></tr>
<tr><td>E-MAIL:</td><td><input type="text" name="mail" /></td></tr>
<tr><td></td><td><input type="submit" value="ADD USER" /></td></tr>
</table>
</div>
</form>
<h2>Company</h2>
<form action="editaccount.php" method="POST" enctype="multipart/form-data">
<div id="box">
<table>
<tr><td>COMPANY LOGIN:</td><td><?php echo $_SESSION['company']; ?></td></tr>
<tr><td>DISPLAY NAME:</td><td><input type="text" name="display" value="<?php echo $info['display']; ?>" /></td></tr>
<tr><td>CURRENCY:</td><td><select name="currency"><option <?php if ($info['currency']=='USD') echo 'selected'; ?>>USD</option><option <?php if ($info['currency']=='EUR') echo 'selected'; ?>>EUR</option><option <?php if ($info['currency']=='GBP') echo 'selected'; ?>>GBP</option><option <?php if ($info['currency']=='PLN') echo 'selected'; ?>>PLN</option></select></td></tr>
<tr><td>LOGO:</td><td><img src="logo/<?php echo $_SESSION['company']; ?>.png" width="100" /></td></tr>
<tr><td>CHANGE:</td><td><input type="file" name="logo" /></td></tr>
<tr><td>COLOR:</td><td><input type="color" name="color" value="<?php echo $info['color']; ?>"/></td></tr>
<tr><td>ADDRESS:</td><td><textarea name="address" onkeyup="limitTextarea(this,5,50)"><?php echo $info['address']; ?></textarea></td></tr>
<tr><td>CONTACT:</td><td><textarea name="contact" onkeyup="limitTextarea(this,2,50)"><?php echo $info['contact']; ?></textarea></td></tr>
<tr><td>BANK INFO:</td><td><textarea name="bank" onkeyup="limitTextarea(this,5,50)"><?php echo $info['bank']; ?></textarea></td></tr>
<tr><td></td><td><input type="submit" value="SAVE SETTINGS" /></td></tr>
<tr><td></td><td><a href="deleteaccount.php">DELETE ACCOUNT</a></td></tr>
</table>
</div>
</form>
<?php
	require('template_end.php');
?>
