<?php
/*
 * invoices.php
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
  		header('Content-Description: CSV Export');
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="export.csv"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		require_once('config.php');
		session_start();
		if ($_SESSION['login']=='') exit('Login error! <a href="' . $url . '/">Back</a>');			
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_info`;');
		$info = mysqli_fetch_array($result);
		if ($_GET['archive']=='true') $archive='1'; else $archive='0';
		if ($_GET['q']=='') $archivequery=' WHERE `' . $_SESSION['company'] . '_products`.archive=' . $archive; else $archivequery='';
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='')
			$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_products`' . $archivequery . ' ORDER BY id;');
		else
			$result = mysqli_query($link,'SELECT * FROM `' . $_SESSION['company'] . '_products`' . $archivequery . ' ORDER BY `' . $_SESSION['company'] . '_products`.' . $_GET['sort'] . $order . ',id;');
		echo '"post_name","post_title","post_content","product_category","sku","price","featured_image"';
		echo "\n";
		while ($row = mysqli_fetch_array($result)) {
			if ($_GET['q']=='' || strpos(strtolower($row['id']), strtolower($_GET['q']))!==false || strpos(strtolower($row['name']), strtolower($_GET['q']))!==false || strpos(strtolower($row['category']), strtolower($_GET['q']))!==false || strpos(strtolower($row['sku']), strtolower($_GET['q']))!==false || strpos(strtolower($row['price']), strtolower($_GET['q']))!==false) {				
				$img='';
				if (file_exists('products/' . $_SESSION['company'] . '_PR' . sprintf('%04d',$row['id'])))
					$img=$url . '/products/' . $_SESSION['company'] . '_PR' . sprintf('%04d',$row['id']);
				echo 'PR' . sprintf('%04d',$row['id']) . ',"' . $row['name'] . '","' . nl2br($row['description']) . '","' . $row['category'] . '","' . $row['sku'] . '",' . number_format($row['price'],2,'.','') . ',"' . $img . '"';
				echo "\n";
			}
		}
		mysqli_free_result($result);
		mysqli_close($link);
		?>		
