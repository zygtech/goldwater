<?php
/*
 * createaccount.php
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
  `brutto` text NOT NULL,
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
		$query = 'CREATE TABLE `' . $_POST['company'] . '_products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `vat` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `sku` varchar(50) NOT NULL,
  `creation` date NOT NULL,
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
  `currency` varchar(3) NOT NULL,
  `productlist` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
		mysqli_query($link,$query);
		if ($_POST['products']==1) $products=1; else $products=0;
		$query = 'INSERT INTO `' . $_POST['company'] . '_info` VALUES (1,"' . $_POST['display'] . '","' . $_POST['address'] . '","' . $_POST['contact'] . '","' . $_POST['bank'] . '","' . $_POST['color'] . '","' . $_POST['currency'] . '",' . $products . ');';
		mysqli_query($link,$query);
		move_uploaded_file($_FILES['logo']['tmp_name'], './logo/' . $_POST['company'] . '.png');
	};
	mysqli_close($link);
?>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>/index.php" />
