<?php
	require_once('config.php');
	session_start();
	if ($_SESSION['login']!='') {
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		?>
<html>

<head>
	<title>Invoices</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="limit.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script>
		$(function(){
			$('.pages').hide();
			$('.p1').show();
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
	<div class="container">
	<img class="right" src="logo.png" />
	<h1> Welcome: <?php echo $_SESSION['login']; ?> <span class="logout">(<a href="index.php?logout=true">log out</a>)</span></h1> 
	</div>
	<div class="ribbon"><div class="container">
	<a class="right" href="invoice.php"><i class="fa fa-plus" aria-hidden="true"></i> Add an invoice</a>
	<?php if ($_GET['q']=='') { ?>
	<form>
	<h2> INVOICES <input name="q" maxlength="20" placeholder="search..." /> <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button></h2>
	</form>
	<?php } else echo '<h2> INVOICES <span class="logout"><a href="invoices.php">show all</a></span></h2>'; ?>
	</div></div>
	<div class="main"><div class="container">
	<table class="data">
	<?php
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='')
			$result = mysqli_query($link,'SELECT `invoices`.id,`invoices`.client,`invoices`.total,`invoices`.added,`clients`.fullname,`clients`.company FROM `invoices` INNER JOIN `clients` ON `invoices`.client = `clients`.id ORDER BY id;');
		else
			$result = mysqli_query($link,'SELECT `invoices`.id,`invoices`.client,`invoices`.total,`invoices`.added,`clients`.fullname,`clients`.company FROM `invoices` INNER JOIN `clients` ON `invoices`.client = `clients`.id ORDER BY ' . $_GET['sort'] . $order . ';');
		?>
		<tr><th style="width: 20%;"><a href="invoices.php?sort=id<?php if ($_GET['sort']=='id' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">INVOICE ID</a></th><th style="width: 30%;"><a href="invoices.php?sort=company<?php if ($_GET['sort']=='company' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">CLIENT</a></th><th style="width: 20%;"><a href="quotes.php?sort=added<?php if ($_GET['sort']=='added' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">BY</a></th><th style="width: 20%;"><a href="invoices.php?sort=total<?php if ($_GET['sort']=='total' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">TOTAL</a></th><th></th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==10) {
				$l=0;
				$p++;
			}
			if ($_GET['q']=='' || strpos(strtolower('INV' . sprintf('%04d',$row['id'])), strtolower($_GET['q']))!==false || strpos(strtolower($row['company']), strtolower($_GET['q']))!==false || strpos(strtolower($row['fullname']), strtolower($_GET['q']))!==false || strpos(strtolower($row['total']), strtolower($_GET['q']))!==false) {				
				echo '<tr class="pages p' . $p . '"><td style="width: 20%;">INV' . sprintf('%04d',$row['id']) . '</td><td style="width: 30%;">';
				if ($row['company']!='') echo $row['company']; else echo $row['fullname'];
				echo ' <a href="client.php?id=' . $row['client'] . '" style="background: none; color: #58585a;" title="Client edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td><td style="width: 20%;">' . $row['added'] . '</td><td style="width: 20%;">£' . $row['total'] . '</td>';
				echo '<td><a href="invoicepdf.php?id=' . $row['id'] . '" title="Invoice save"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></td><td><a href="invoice.php?id=' . $row['id'] . '" title="Invoice edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td><td><a class="confirm" href="invoicedel.php?id=' . $row['id'] . '" title="Invoice delete"><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>';
				$l++;
			}
		}
		mysqli_free_result($result);
		mysqli_close($link);
		for ($n=$l;$n<10;$n++) 
			echo '<tr class="pages p' . $p . '"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	?>
	</table><br /><center>	
	<?php 
	if ($p>1) 
		for ($n=1;$n<=$p;$n++) {
			?><a style="cursor: pointer;" onclick="$('.pages').hide(); $('.p<?php echo $n; ?>').show();"><?php echo $n; ?></a>&nbsp;<?php
		}
	?></center><br />
	</div></div>
	<div class="ribbon"><div class="container">
	<?php require_once('menu.php'); ?>
	</div></div>
</body>

</html>
<?php
	}
?>
