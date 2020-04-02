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
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
    <link rel="icon" href="../icon.png" sizes="100x100">
</head>

<body>
<div class="container">
<img class="right" src="../logo.png" />
<h1> Goldwater Business </h1>
</div>
<div class="ribbonlogin"><div class="container">
<h2> ZALOGUJ SIĘ </h2>
</div></div>
<div class="mainlogin"><div class="container">
<form action="login.php" method="POST">
<div id="box">
<table>
<tr><td>FIRMA:</td><td><input type="text" name="company" pattern="[A-Za-z0-9\S]{1,20}" /></td></tr>
<tr><td>LOGIN:</td><td><input type="text" name="user" pattern="[A-Za-z0-9\S]{1,20}" /></td></tr>
<tr><td>HASŁO:</td><td><input type="password" name="pass" /></td></tr>
<tr><td></td><td><input type="submit" value="ZALOGUJ" /></td></tr>
<tr><td></td><td><a href="addaccount.php">ZAREJESTRUJ FIRMĘ ZA DARMO</a></td></tr>
</table>
</div>
</form>
</div></div>
<div class="ribbonlogin"><center><a href="<?php echo $url; ?>/"><img src="../uk.jpg" height="50" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $url; ?>/pl/"><img src="../pl.png" height="50" /></a></center></div>
</body>

</html>
<?php } else {
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/pl/tasks.php"> 
<?php
}
?>
