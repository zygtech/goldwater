<?php
/*
 * index.php
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
	require_once('config.php');
	session_start();
	if ($_GET['logout']=='true' || $_SESSION['login']=='') {
		$_SESSION['login']='';
?>
<html>

<head>
	<title>Goldwater Business</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="limit.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
</head>

<body>
<div class="container">
<img class="right" src="logo.png" />
<h1> Goldwater Business <span class="logout">(<a href="/">back</a>)</span></h1>
</div>
<div class="ribbonlogin"><div class="container">
<h2> ADD COMPANY </h2>
</div></div>
<div class="mainlogin"><div class="container">
<form action="createaccount.php" method="POST" enctype="multipart/form-data">
<div id="box">
<table>
<tr><td>COMPANY LOGIN*:</td><td><input type="text" name="company" pattern="[A-Za-z0-9\S]{1,20}" minlength="5"/></td></tr>
<tr><td>DISPLAY NAME*:</td><td><input type="text" name="display" /></td></tr>
<tr><td>LOGIN*:</td><td><input type="text" name="login" pattern="[A-Za-z0-9\S]{1,20}" /></td></tr>
<tr><td>PASSWORD*:</td><td><input type="password" name="pass" /></td></tr>
<tr><td>E-MAIL*:</td><td><input type="text" name="mail" /></td></tr>
<tr><td>CURRENCY*:</td><td><select name="currency"><option>USD</option><option>EUR</option><option>GBP</option><option>PLN</option></select></td></tr>
<tr><td>LOGO*:</td><td><input type="file" name="logo" /></td></tr>
<tr><td>COLOR*:</td><td><input type="color" name="color" value="#555555" /></td></tr>
<tr><td>ADDRESS:</td><td><textarea name="address" onkeyup="limitTextarea(this,5,50)"></textarea></td></tr>
<tr><td>CONTACT:</td><td><textarea name="contact" onkeyup="limitTextarea(this,2,50)"></textarea></td></tr>
<tr><td>BANK INFO:</td><td><textarea name="bank" onkeyup="limitTextarea(this,5,50)"></textarea></td></tr>
<tr><td></td><td><input type="submit" value="CREATE AN ACCOUNT" /></td></tr>
<tr><td></td><td>* required fields</td></tr>
</table>
</div>
</form>
</div></div>
<div class="ribbonlogin">&nbsp;</div>
</body>

</html>
<?php } else {
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/tasks.php"> 
<?php
}
?>
