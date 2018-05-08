<?php
	require_once('config.php');
	session_start();
	if ($_SESSION['login']!='') {
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		?>
<html>

<head>
	<title>Clients</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A00&#038;subset=latin" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="limit.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script>
		function category(sel,id)
		{
			$.ajax('clientswitch.php?id='+id+'&category='+sel.value);	
		}
		function priority(sel,id)
		{
			$.ajax('clientswitch.php?id='+id+'&priority='+sel.value);	
		}
        function checkall()
        {
            if ($('.all').is(':checked')) 
                $('.emails').prop('checked', true);
            else
                $('.emails').prop('checked', false);
        }
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
	<a class="right" href="client.php"><i class="fa fa-plus" aria-hidden="true"></i> Add a client</a>
	<?php if ($_GET['q']=='') { ?>	
	<form>
	<h2> CLIENTS <input name="q" maxlength="20" placeholder="search..." /> <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button></h2>
	</form>
	<?php } else echo '<h2> CLIENTS <span class="logout"><a href="clients.php">show all</a></span></h2>'; ?>
	</div></div>
	<div class="main"><div class="container">
	<table class="data">
	<?php
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='') 
			$result = mysqli_query($link,'SELECT id,fullname,company,mobile,priority,category,mail FROM `clients` ORDER BY id;');
		else
			$result = mysqli_query($link,'SELECT id,fullname,company,mobile,priority,category,mail FROM `clients` ORDER BY ' . $_GET['sort'] . $order . ';');
		?>
        <form action="mailform.php" method="POST">
		<tr><th><input type="checkbox" class="all" name="all" onclick="checkall();" /></th><th style="width: 10%;"><a href="clients.php?sort=id<?php if ($_GET['sort']=='id' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">CLIENT ID</a></th><th style="width: 20%;"><a href="clients.php?sort=company<?php if ($_GET['sort']=='company' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">COMPANY</a></th><th style="width: 25%;"><a href="clients.php?sort=fullname<?php if ($_GET['sort']=='fullname' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">FULL NAME</a></th><th style="width: 20%;"><a href="clients.php?sort=mobile<?php if ($_GET['sort']=='mobile' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">MOBILE</a></th><th><a href="clients.php?sort=category<?php if ($_GET['sort']=='category' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">CATEGORY</a></th><th><a href="clients.php?sort=priority<?php if ($_GET['sort']=='priority' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">PRI</a></th><th></th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==10) {
				$l=0;
				$p++;
			}
			if ($_GET['q']=='' || strpos(strtolower('CL' . sprintf('%04d',$row['id'])), strtolower($_GET['q']))!==false || strpos(strtolower($row['fullname']), strtolower($_GET['q']))!==false || strpos(strtolower($row['company']), strtolower($_GET['q']))!==false || strpos(strtolower($row['mail']), strtolower($_GET['q']))!==false) {
				echo '<tr class="pages p' . $p . '"><td><input type="checkbox" class="emails" name="emails[]" value="' . $row['mail'] . '" /></td><td style="width: 10%;">CL' . sprintf('%04d',$row['id']) . '</a></td><td style="width: 20%;">' . $row['company'] . '</td><td style="width: 25%;">' . $row['fullname'] . '</td><td style="width: 20%;">' . $row['mobile'];
				echo '</td><td>';
				?>
				<select onchange="category(this,<?php echo $row['id']; ?>);">
					<option <?php if ($row['category']=='ACTIVE') echo 'selected'; ?>>ACTIVE</option>
					<option <?php if ($row['category']=='RING') echo 'selected'; ?>>RING</option>
					<option <?php if ($row['category']=='FREEZE') echo 'selected'; ?>>FREEZE</option>
					<option disabled <?php if ($row['category']=='NEW') echo 'selected'; ?>>NEW</option>
				</select>
				</td><td>
				<select onchange="priority(this,<?php echo $row['id']; ?>);">
					<option <?php if ($row['priority']=='1') echo 'selected'; ?>>1</option>
					<option <?php if ($row['priority']=='2') echo 'selected'; ?>>2</option>
					<option <?php if ($row['priority']=='3') echo 'selected'; ?>>3</option>
				</select>
				<?php
				echo '</td><td><center><a href="client.php?id=' . $row['id'] . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></center></td><td><center><a class="confirm" href="clientdel.php?id=' . $row['id'] . '"><i class="fa fa-trash" aria-hidden="true"></i></a></center></td></tr>';  
				$l++;
			}			
		}
		mysqli_free_result($result);
		mysqli_close($link);
	?>
	</table><br /><center>	
	<?php 
	if ($p>1) 
		for ($n=1;$n<=$p;$n++) {
			?><a style="cursor: pointer;" onclick="$('.pages').hide(); $('.p<?php echo $n; ?>').show();"><?php echo $n; ?></a>&nbsp;<?php
		}
	?></center><br />
	<input type="submit" value="Send e-mails" /></form>
	</div></div>
	<div class="ribbon"><div class="container">
	<?php require_once('menu.php'); ?>
	</div></div>
</body>

</html>
<?php
	}
?>
