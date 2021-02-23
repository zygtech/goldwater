<?php
/*
 * deleteaccount.php
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
<html>

<head>
	<title>Goldwater</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
</head>

<body>
	<div class="container">
<img class="right" src="logo/<?php echo $_GET['company']; ?>.png" />
<h1> Goldwater Business </h1>
</div>
<div class="ribbonlogin"><div class="container">
<h2> USER PASSWORD: <?php echo $_GET['login']; ?></h2>
</div></div>
<div class="mainlogin"><div class="container">
<form action="adduser.php" method="POST">
<center><table><tr><td><input type="password" name="password" /></td><td><input type="submit" value="SET PASSWORD" /></td></tr></table> </center>
<input type="hidden" name="check" value="<?php echo $_GET['code']; ?>" />
<input type="hidden" name="company" value="<?php echo $_GET['company']; ?>" />
<input type="hidden" name="mail" value="<?php echo $_GET['mail']; ?>" />
<input type="hidden" name="login" value="<?php echo $_GET['login']; ?>" />
</form>
</div></div>
<div class="ribbonlogin"><div class="container">
&nbsp;
</div></div>
</body>

</body>

</html>

