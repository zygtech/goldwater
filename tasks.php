<?php
	require_once('config.php');
	session_start();
	if ($_SESSION['login']!='') {
		$link = mysqli_connect($sql, $sqluser, $sqlpass, $sqldb);
		mysqli_set_charset($link,'utf8');
		?>
<html>

<head>
	<title>Tasks</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web%3A400%2C300%2C900%7CPT+Sans%3A700&#038;subset=latin" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
	<?php if ($_GET['q']=='') { ?>
	<form>
	<h2> TASKS <input name="q" maxlength="20" placeholder="search..." /> <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button></h2>
	</form>
	<?php } else echo '<h2> TASKS <span class="logout"><a href="tasks.php">show all</a></span></h2>'; ?>
	</div></div>
	<div class="main"><div class="container">
	<table class="data">
	<?php
		if ($_GET['archive']=='true') $archive='1'; else $archive='0';
		if ($_GET['q']=='') $archivequery=' AND `tasks`.archive=' . $archive; else $archivequery='';
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='')
			$result = mysqli_query($link,'SELECT `tasks`.id,`tasks`.job,`tasks`.name,`tasks`.archive,`tasks`.added,`jobs`.id AS jobid,`jobs`.name AS jobname FROM `tasks` INNER JOIN `jobs` ON `jobs`.id=`tasks`.job WHERE `tasks`.added="' . $_SESSION['login'] . '"' . $archivequery . ' ORDER BY id;');
		else
			$result = mysqli_query($link,'SELECT `tasks`.id,`tasks`.job,`tasks`.name,`tasks`.archive,`tasks`.added,`jobs`.id AS jobid,`jobs`.name AS jobname FROM `tasks` INNER JOIN `jobs` ON `jobs`.id=`tasks`.job WHERE `tasks`.added="' . $_SESSION['login'] . '"' . $archivequery . ' ORDER BY ' . $_GET['sort'] . $order . ';');
		?>
		<tr><th style="width: 24%;">JOB</th><th style="width: 70%;">TASK</th><th></th></tr>
		<?php
		$p=1; $l=0;
		while ($row = mysqli_fetch_array($result)) {
			if ($l==10) {
				$l=0;
				$p++;
			}
			if ($row['archive']==1 && $_GET['archive']!='true') $archivecolor=' style="background: #eeee99 !important;"'; else $archivecolor='';
			if ($_GET['q']=='' || strpos(strtolower($row['name']), strtolower($_GET['q']))!==false) {				
				echo '<tr' .  $archivecolor . ' class="pages p' . $p . '"><td style="width: 24%;">' . $row['jobname'] . '</td><td style="width: 70%;">' . $row['name'] . '</td>';
				if ($row['archive']==0)
					echo '<td style="width: 6%; text-align: right;">';
				else
					echo '<td style="width: 6%; text-align: right;"><a href="taskedit.php?id=' . $row['id'] . '&job=' . $row['jobid'] . '&return=s" title="Task revive"><i class="fa fa-undo" aria-hidden="true"></i></a>';	
				echo ' <a class="confirm" href="taskdel.php?id=' . $row['id'] . '&job=' . $row['jobid'] . '&return=s" title="Task tick/delete">';
				if ($row['archive']==1) echo '<i class="fa fa-trash" aria-hidden="true"></i>'; else echo '<i class="fa fa-check" aria-hidden="true"></i>';
				echo '</a></td></tr>';
			$l++;
			}
		}
		mysqli_free_result($result);
		mysqli_close($link);
		for ($n=$l;$n<10;$n++) 
			echo '<tr class="pages p' . $p . '"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	?>
	</table><br /><center>	
	<?php 
	if ($p>1) 
		for ($n=1;$n<=$p;$n++) {
			?><a style="cursor: pointer;" onclick="$('.pages').hide(); $('.p<?php echo $n; ?>').show();"><?php echo $n; ?></a>&nbsp;<?php
		}
	?></center><br />
	<center><?php if ($_GET['archive']!='true') echo '<a href="tasks.php?archive=true&id=' . $_GET['id'] . '">Archive</a>'; else echo '<a href="tasks.php?id=' . $_GET['id'] . '">Back</a>'; ?></center>
	</div></div>
	<div class="ribbon"><div class="container">
	<?php require_once('menu.php'); ?>
	</div></div>
</body>

</html>
<?php
	}
?>
