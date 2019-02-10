<?php
/*
 * info.php
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
	require_once('../config.php');
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
	$result = mysqli_query($link,'SELECT * FROM `' . $_POST['company'] . '_users` WHERE name="' . $_POST['user'] . '";');
	$check = mysqli_fetch_array($result);
	if ($check['pass']==md5($_POST['pass'])) {
		$result = mysqli_query($link,'SELECT `' . $_POST['company']. '_tasks`.job FROM `' . $_POST['company']. '_tasks` WHERE `' . $_POST['company'] . '_tasks`.added="' . $_POST['user'] . '" AND `' . $_POST['company'] . '_tasks`.archive=0 ORDER BY id DESC;');
		$i=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($i==$_POST['pos']) {
				$jobresult = mysqli_query($link,'SELECT `' . $_POST['company']. '_jobs`.name,`' . $_POST['company']. '_clients`.fullname,`' . $_POST['company']. '_clients`.company,`' . $_POST['company']. '_clients`.address,`' . $_POST['company']. '_clients`.mobile FROM `' . $_POST['company']. '_jobs` INNER JOIN `' . $_POST['company']. '_clients` ON  `' . $_POST['company']. '_jobs`.client=`' . $_POST['company']. '_clients`.id WHERE `' . $_POST['company'] . '_jobs`.id=' . $row['job'] . ';');
				$job = mysqli_fetch_array($jobresult);
				echo "$";
				if ($job['company']!='') echo $job['company'] . '$';
				if ($job['fullname']!='') echo $job['fullname'] . '$'; 
				if ($job['address']!='') echo str_replace("\n",'$',$job['address']) . "$";
				if ($job['mobile']!='') echo  $job['mobile'] . "$"; 
			}
			$i++;
		}
	}
?>
