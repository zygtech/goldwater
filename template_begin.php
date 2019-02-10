<?php
/*
 * template_begin.php
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
	if ($_SESSION['login']=='') exit('Login error! <a href="' . $url . '/">Back</a>');			
	$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
	mysqli_set_charset($link,'utf8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Goldwater</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="limit.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script>
		function additem(sel,id)
		{
			if (sel.value!='') {
				$('#lp'+id).html(parseInt(id)+1);
				$('#type'+id).prop('disabled', false);
				$('#netto'+id).prop('disabled', false);
				$('#vat'+id).prop('disabled', false);
				var idn=parseInt(id)+1;
				$('#row'+idn).show();
			}
			else
				$('#lp'+id).html('&nbsp;');
		}
		function calcvat(sel,id)
		{
			if (parseFloat($('#netto'+id).val())>500000) $('#netto'+id).val('500000');
			var vat = ($('#netto'+id).val()*$('#vat'+id).val()/100);
			$('#vatvalue'+id).text(vat.toFixed(2));
			var total = parseFloat(vat.toFixed(2)) + parseFloat($('#netto'+id).val());
			$('#total'+id).text(total.toFixed(2));
			if (parseFloat($('#vat'+id).val())>0) $('#vat'+id).val(parseFloat($('#vat'+id).val()).toFixed(0)); else { 
				$('#vat'+id).val('');
				$('#vatvalue'+id).html('&nbsp;');
				$('#total'+id).text(parseFloat($('#netto'+id).val()).toFixed(2));
			}
			if (parseFloat($('#netto'+id).val())>0) $('#netto'+id).val(parseFloat($('#netto'+id).val()).toFixed(2)); else { 
				$('#netto'+id).val('');
				$('#vatvalue'+id).html('&nbsp;');
				$('#total'+id).html('&nbsp;');
			}
			var i;
			var num = 0.00;
			for (i=0;i<20;i++) {
				if (parseFloat($('#total'+i).text()).toFixed(2)>0) num += parseFloat($('#total'+i).text());
			}
			$('#total').text(num.toFixed(2))
		}
		function phone(sel)
		{
			$("#phone").load('phone.php?id='+sel.value.replace(/ /g,"%20"));
		}
		function job_stage(sel,id)
		{
			$.ajax('jobswitch.php?id='+id+'&stage='+sel.value);	
		}
		function job_priority(sel,id)
		{
			$.ajax('jobswitch.php?id='+id+'&priority='+sel.value);	
		}
		function client_category(sel,id)
		{
			$.ajax('clientswitch.php?id='+id+'&category='+sel.value);	
		}
		function client_priority(sel,id)
		{
			$.ajax('clientswitch.php?id='+id+'&priority='+sel.value);	
		}
		function checkall()
        {
            if ($('.all').is(':checked')) 
                $('.checks').prop('checked', true);
            else
                $('.checks').prop('checked', false);
        }
		$(function(){
			$('.confirm').click(function(event){
				event.preventDefault();
				$.confirm({
					title     : 'Confirm',
					content   : 'Are you sure?',
					buttons   : {
						'Yes'   : {
							action: function(){
								window.location = $(event.currentTarget).attr('href');
							}

						},
						'No'   : {
							action: function(){} 
						}
					}
				});		
			});
		});
	</script>
</head>

<body>
	<div id="ribbon">
		<div class="in">
			<div class="left">
				<a class="logout" href="index.php?logout=true"><img src="logo.png" /></a>
				<span class="text"><a href="<?php echo $url; ?>/"><img src="uk.jpg" height="16" /></a> <a href="<?php echo $url; ?>/pl/"><img src="pl.png" height="16" /></a></span>
				<form>
				<input type="text" name="q" maxlength="20" placeholder="Search..." />
				<button type="submit" title="Search"><i class="fa fa-search" aria-hidden="true"></i></button> 
				</form>
			</div>
			<div class="right">
				<img src="logo/<?php echo $_SESSION['company']; ?>.png" />
				<span class="text"><strong><?php echo $_SESSION['display']; ?></strong></span> <span class="tools"> <a href="tasks.php" title="Tasks"><i class="fa fa-tasks" aria-hidden="true"></i></a> <a href="jobs.php" title="Jobs"><i class="fa fa-briefcase" aria-hidden="true"></i></a> <a href="clients.php" title="Clients"><i class="fa fa-user" aria-hidden="true"></i></a> <a href="invoices.php" title="Invoices"><i class="fa fa-file" aria-hidden="true"></i></a> <a href="quotes.php" title="Quotes"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a href="settings.php" title="Settings"><i class="fa fa-wrench" aria-hidden="true"></i></a></span>
			</div>
		</div>
	</div>
	<div id="main">
		<div class="left">
			<div id="zlecenia">
				<a href="job.php" title="Add a job"><center><strong>ADD A JOB</strong><br /><i class="fa fa-briefcase" aria-hidden="true" style="font-size: 48px;"></i></a></center>
				<center><a href="jobs.php">Show all jobs</a></center>
			</div>
			<div id="klienci">
				<a href="client.php" title="Add a client"><center><strong>ADD A CLIENT</strong><br /><i class="fa fa-user" aria-hidden="true" style="font-size: 48px;"></i></a></center>
				<center><a href="clients.php">Show all clients</a></center>
			</div>
			<div id="faktury">
				<a href="invoice.php" title="Add an invoice"><center><strong>ADD AN INVOICE</strong><br /><i class="fa fa-file" aria-hidden="true" style="font-size: 48px;"></i></a></center>
				<center><a href="invoices.php">Show all invoices</a><br /></center>
			</div>
			<div id="noty">
				<a href="quote.php" title="Add a quote"><center><strong>ADD A QUOTE</strong><br /><i class="fa fa-pencil" aria-hidden="true" style="font-size: 48px;"></i></a></center>
				<center><a href="quotes.php">Show all quotes</a><br /></center>
			</div>

			
			

		</div>
		<div class="right">
