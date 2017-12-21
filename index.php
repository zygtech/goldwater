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
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/jobs.php"> 
<?php
}
?>