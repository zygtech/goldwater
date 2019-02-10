<?php
	require_once('config.php');
	session_start();
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link,'SELECT * FROM `' . $_POST['company'] . '_users`;');
	if (strlen($_POST['company'])>4 && $_POST['mail']!='' && $_POST['login']!='' && $_POST['pass']!='' && !(mysqli_num_rows($result)>0) && $_FILES['logo']['tmp_name']!='') {
		$query = 'CREATE TABLE `' . $_POST['company'] . '_clients` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `www` varchar(50) NOT NULL,
  `info` text NOT NULL,
  `folder` varchar(50) NOT NULL,
  `category` varchar(20) NOT NULL,
  `priority` smallint(6) NOT NULL,
  `nip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		mysqli_query($link,$query);
				
		$query = 'CREATE TABLE `' . $_POST['company'] . '_invoices` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `client` int(11) NOT NULL,
  `clientinfo` text NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL,
  `netto` text NOT NULL,
  `total` float NOT NULL,
  `creation` date NOT NULL,
  `added` varchar(20) NOT NULL,
  `vat` text NOT NULL,
  `invoiceid` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `info` varchar(255) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		mysqli_query($link,$query);
		
		$query = 'CREATE TABLE `' . $_POST['company'] . '_jobs` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `client` int(11) NOT NULL,
  `description` text NOT NULL,
  `creation` date NOT NULL,
  `stage` varchar(20) NOT NULL,
  `info` text NOT NULL,
  `added` varchar(20) NOT NULL,
  `finished` date DEFAULT NULL,
  `required` date NOT NULL,
  `priority` smallint(6) NOT NULL,
  `archive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		mysqli_query($link,$query);
		
		$query = 'CREATE TABLE `' . $_POST['company'] . '_quotes` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `client` int(11) NOT NULL,
  `clientinfo` text NOT NULL,
  `description` text NOT NULL,
  `creation` date NOT NULL,
  `added` varchar(20) NOT NULL,
  `quoteid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		mysqli_query($link,$query);
		$query = 'CREATE TABLE `' . $_POST['company'] . '_tasks` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `job` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `added` varchar(20) NOT NULL,
  `archive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		mysqli_query($link,$query);
		$query = 'CREATE TABLE `' . $_POST['company'] . '_users` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		mysqli_query($link,$query);
		$query = 'INSERT INTO `' . $_POST['company'] . '_users` VALUES (0,"' . $_POST['login'] . '","' . $_POST['mail'] . '","' . md5($_POST['pass']) . '");';
		mysqli_query($link,$query);
		$query = 'CREATE TABLE `' . $_POST['company'] . '_info` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `display` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `color` varchar(10) NOT NULL,
  `currency` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		mysqli_query($link,$query);
		$query = 'INSERT INTO `' . $_POST['company'] . '_info` VALUES (1,"' . $_POST['display'] . '","' . $_POST['address'] . '","' . $_POST['contact'] . '","' . $_POST['bank'] . '","' . $_POST['color'] . '","' . $_POST['currency'] . '");';
		mysqli_query($link,$query);
		move_uploaded_file($_FILES['logo']['tmp_name'], './logo/' . $_POST['company'] . '.png');
	};
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/index.php" />
