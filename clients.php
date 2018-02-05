<?php
	require_once('config.php');
	session_start();
	if (!isset($_SESSION['login'])) {
		header("Location: index.php");
		exit;
	}
	if ($_SESSION['login']=='design') {
		header("Location: tasks.php");
		exit;
	}
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
	<script src="limit.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
	</script>
</head>

<body>
	<div class="ribbon"><div class="container">
	<?php require('menu.php'); ?>	
	</div></div>
	<div class="container">
	<img class="right" src="logo.png" />
	<h1> Welcome: <?php echo $_SESSION['login']; ?> <span class="logout">(<a href="index.php?logout=true">log out</a>)</span></h1> 
	</div>
	<div class="ribbon"><div class="container">
	<a class="right" href="client.php"><i class="fa fa-plus" aria-hidden="true"></i> Add a client</a>
	<?php if ($_GET['q']=='') { ?>	
	<form>
	<h2> CLIENTS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="q" maxlength="20" placeholder="search..." /> <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> </h2>
	</form>
	<?php } else echo '<h2> CLIENTS <span class="logout"><a href="clients.php">show all</a></span></h2>'; ?>
	</div></div>
	<div class="main"><div class="container">
	<table class="data">
	<?php
		if ($_GET['archive']=='true') $archive='1'; else $archive='0';
		if ($_GET['q']=='') $archivequery=' WHERE `clients`.archive=' . $archive; else $archivequery='';
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='') 
			$result = mysqli_query($link,'SELECT id,fullname,company,mobile,priority,category,archive,mail FROM `clients`' . $archivequery . ' ORDER BY id;');
		else
			$result = mysqli_query($link,'SELECT id,fullname,company,mobile,priority,category,archive,mail FROM `clients`' . $archivequery . ' ORDER BY ' . $_GET['sort'] . $order . ';');
		?>
		<form action="mailform.php" method="POST">
		<tr><th><input type="checkbox" class="all" name="all" onclick="checkall();" /></th><th style="width: 10%;"><a href="clients.php?sort=id<?php if ($_GET['sort']=='id' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">CLIENT ID</a></th><th style="width: 20%;"><a href="clients.php?sort=company<?php if ($_GET['sort']=='company' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">COMPANY</a></th><th style="width: 25%;"><a href="clients.php?sort=fullname<?php if ($_GET['sort']=='fullname' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">FULL NAME</a></th><th style="width: 20%;"><a href="clients.php?sort=mobile<?php if ($_GET['sort']=='mobile' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">MOBILE</a></th><th><a href="clients.php?sort=category<?php if ($_GET['sort']=='category' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">CATEGORY</a></th><th><a href="clients.php?sort=priority<?php if ($_GET['sort']=='priority' && $_GET['order']=='') echo '&order=DESC'; ?><?php if ($_GET['q']!='') echo '&q=' . $_GET['q']; ?>">PRI</a></th><th></th><th></th></tr>
		<?php
		while ($row = mysqli_fetch_array($result)) {
			if ($_GET['q']=='' || strpos(strtolower('CL' . sprintf('%04d',$row['id'])), strtolower($_GET['q']))!==false || strpos(strtolower($row['fullname']), strtolower($_GET['q']))!==false || strpos(strtolower($row['company']), strtolower($_GET['q']))!==false || strpos(strtolower($row['mail']), strtolower($_GET['q']))!==false) {
				echo '<tr><td><input type="checkbox" class="emails" name="emails[]" value="' . $row['mail'] . '" /></td><td style="width: 10%;">CL' . sprintf('%04d',$row['id']) . '</a></td><td style="width: 20%;">' . $row['company'] . '</td><td style="width: 25%;">' . $row['fullname'] . '</td><td style="width: 20%;">' . $row['mobile'];
				echo '</td><td>';
				?>
				<select onchange="category(this,<?php echo $row['id']; ?>);">
					<option <?php if ($row['category']=='ACTIVE') echo 'selected'; ?>>ACTIVE</option>
					<option <?php if ($row['category']=='RING') echo 'selected'; ?>>RING</option>
					<option <?php if ($row['category']=='IDIOT') echo 'selected'; ?>>IDIOT</option>
					<option disabled <?php if ($row['category']=='NEW') echo 'selected'; ?>>NEW</option>
				</select>
				</td><td>
				<select onchange="priority(this,<?php echo $row['id']; ?>);">
					<option <?php if ($row['priority']=='1') echo 'selected'; ?>>1</option>
					<option <?php if ($row['priority']=='2') echo 'selected'; ?>>2</option>
					<option <?php if ($row['priority']=='3') echo 'selected'; ?>>3</option>
					<option <?php if ($row['priority']=='4') echo 'selected'; ?>>4</option>
					<option <?php if ($row['priority']=='5') echo 'selected'; ?>>5</option>
					<option <?php if ($row['priority']=='6') echo 'selected'; ?>>6</option>
					<option <?php if ($row['priority']=='7') echo 'selected'; ?>>7</option>
					<option <?php if ($row['priority']=='8') echo 'selected'; ?>>8</option>
					<option <?php if ($row['priority']=='9') echo 'selected'; ?>>9</option>
				</select>
				<?php
				echo '</td><td><center>';
				if ($row['archive']==0)
					echo '<a href="client.php?id=' . $row['id'] . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				else
					echo '<a href="clientedit.php?id=' . $row['id'] . '"><i class="fa fa-undo" aria-hidden="true"></i></a>';				
				echo '</center></td><td><center><a href="clientdel.php?id=' . $row['id'] . '"><i class="fa fa-trash" aria-hidden="true"></i></a></center>';
				echo '</td></tr>';
			}
		}
		mysqli_free_result($result);
		mysqli_close($link);
	?>
	</table><br />
	<input type="submit" value="Send e-mails" /></form><br /><br />
	<center><?php if ($_GET['archive']!='true') echo '<a href="clients.php?archive=true">Archive</a>'; else echo '<a href="clients.php">Back</a>'; ?></center>
	</div></div>
	<div class="ribbon"><div class="container">
	<?php require('menu.php'); ?>
	</div></div>
</body>

</html>
<?php
	}
?>
