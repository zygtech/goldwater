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
	require_once('config.php');
	session_start();
	if ($_SESSION['login']!='') {
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		if ($_GET['id']!='') {
			$result = mysqli_query($link,'SELECT * FROM `clients` WHERE id=' . $_GET['id'] . ';');
			$client = mysqli_fetch_array($result);
		}
		?>
<html>

<head>
	<title>Client Edit</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A700&#038;subset=latin" rel="stylesheet">
	<script src="limit.js"></script>
</head>

<body>
	<div class="container">
	<img class="right" src="logo.png" />
	<h1> Welcome: <?php echo $_SESSION['login']; ?> <span class="logout">(<a href="index.php?logout=true">log out</a>)</span></h1>
	</div>
	<div class="ribbon"><div class="container">
	<h2> CLIENT EDIT </h2>
	</div></div>
	<div class="main"><div class="container">
	<form action="clientedit.php" method="POST">
	<table>
    <input type="hidden" name="id" value="<?php echo $client['id']; ?>" />
	<tr><td>Company</td><td><input type="text" name="company" value="<?php echo $client['company']; ?>" maxlength="50" /></td></tr>
	<tr><td>Full name</td><td><input type="text" name="fullname" value="<?php echo $client['fullname']; ?>" maxlength="20" /></td></tr>
	<tr><td>Address</td><td><textarea name="address" onkeyup="limitTextarea(this,5,100)"><?php echo $client['address']; ?></textarea></td></tr>
	<tr><td>Mobile</td><td><input type="text" name="mobile" value="<?php echo $client['mobile']; ?>" maxlength="20" /></td></tr>
	<tr><td>E-mail</td><td><input type="text" name="mail" value="<?php echo $client['mail']; ?>" maxlength="50" /></td></tr>
	<tr><td>WWW</td><td><input type="text" name="www" value="<?php echo $client['www']; ?>" maxlength="50" /></td></tr>
	<tr><td>Folder</td><td><input type="text" name="folder" value="<?php echo $client['folder']; ?>" maxlength="50" /></td></tr>
	<tr><td>Category</td><td><select name="category">
	<option <?php if ($client['category']=='ACTIVE') echo 'selected'; ?>>ACTIVE</option>
	<option <?php if ($client['category']=='RING') echo 'selected'; ?>>RING</option>
	<option <?php if ($client['category']=='FREEZE') echo 'selected'; ?>>FREEZE</option>
	<option disabled <?php if ($client['category']=='NEW') echo 'selected'; ?>>NEW</option>
	</select></td></tr>
	<tr><td>Additional Info</td><td><textarea name="info" onkeyup="limitTextarea(this,5,100)"><?php echo $client['info']; ?></textarea></td></tr>
	<tr><td></td><td><input type="submit" value="Save" /></td></tr>
	</table>
	</form>
	</div></div>
	<div class="ribbon"><div class="container">
	<?php require_once('menu.php'); ?>
	</div></div>
</body>

</html>
<?php
	}
?>
