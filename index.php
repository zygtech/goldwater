<?php
/*
 * bez nazwy.php
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
	<title>Your Invoice</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
</head>

<body>
<div class="container">
<img class="right" src="logo.png" />
<h1> Your Invoice </h1>
</div>
<div class="ribbon"><div class="container">
<h2> LOG IN </h2>
</div></div>
<div class="main"><div class="container">
<form action="login.php" method="POST">
<div id="box">
<table>
<tr><td>LOGIN:</td><td><input type="text" name="user" pattern="[A-Za-z0-9\S]{1,20}" /></td></tr>
<tr><td>PASS:</td><td><input type="password" name="pass" /></td></tr>
<tr><td></td><td><input type="submit" value="LOG IN" /></td></tr>
</table>
</div>
</form>
</div></div>
<div class="ribbon"><div class="container">
<h2>&nbsp;</h2>
</div></div>
</body>

</html>
<?php } else {
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/tasks.php"> 
<?php
}
?>
