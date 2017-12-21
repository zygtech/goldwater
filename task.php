<?php
	require_once('config.php');
	session_start();
	if ($_SESSION['login']!='' && $_GET['id']!='') {
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
</head>

<body>
	<div class="container">
	<img class="right" src="logo.png" />
	<h1> Welcome: <?php echo $_SESSION['login']; ?> <span class="logout">(<a href="index.php?logout=true">log out</a>)</span></h1> 
	</div>
	<div class="ribbon"><div class="container">
	<?php if ($_GET['q']=='') { ?>
	<form>
	<input name="id" type="hidden" value="<?php echo $_GET['id']; ?>" />
	<h2> TASKS <input name="q" maxlength="20" placeholder="search..." /> <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button></h2>
	</form>
	<?php } else echo '<h2> TASKS <span class="logout"><a href="task.php?id=' . $_GET['id'] . '">show all</a></span></h2>'; ?>
	</div></div>
	<div class="main"><div class="container">
	<table class="data">
	<?php
		if ($_GET['archive']=='true') $archive='1'; else $archive='0';
		if ($_GET['q']=='') $archivequery=' AND `tasks`.archive=' . $archive; else $archivequery='';
		if ($_GET['order']=='DESC') $order=' DESC';
		if ($_GET['sort']=='')
			$result = mysqli_query($link,'SELECT `tasks`.id,`tasks`.job,`tasks`.name,`tasks`.archive,`tasks`.added FROM `tasks` WHERE `tasks`.job=' . $_GET['id'] . $archivequery . ' ORDER BY id;');
		else
			$result = mysqli_query($link,'SELECT `tasks`.id,`tasks`.job,`tasks`.name,`tasks`.archive,`tasks`.added FROM `tasks` WHERE `tasks`.job=' . $_GET['id'] . $archivequery . ' ORDER BY ' . $_GET['sort'] . $order . ';');
		?>
		<tr><th style="width: 64%;">TASK</th><th style="width: 30%;">USER</th><th></th></tr>
		<?php
		while ($row = mysqli_fetch_array($result)) {
			if ($row['archive']==1 && $_GET['archive']!='true') $archivecolor=' style="background: #eeee99 !important;"'; else $archivecolor='';
			if ($_GET['q']=='' || strpos(strtolower($row['name']), strtolower($_GET['q']))!==false) {				
				echo '<tr' .  $archivecolor . '><td style="width: 64%;">' . $row['name'] . '</td><td style="width: 30%;">' . $row['added'] . '</td>';
				if ($row['archive']==0)
					echo '<td style="width: 6%; text-align: right;">';
				else
					echo '<td style="width: 6%; text-align: right;"><a href="taskedit.php?id=' . $row['id'] . '&job=' . $_GET['id'] . '"><i class="fa fa-undo" aria-hidden="true"></i></a>';	
				echo ' <a href="taskdel.php?id=' . $row['id'] . '&job=' . $_GET['id'] . '">';
				if ($row['archive']==1) echo '<i class="fa fa-trash" aria-hidden="true"></i>'; else echo '<i class="fa fa-check" aria-hidden="true"></i>';
				echo '</a></td></tr>';
			}
		}
		mysqli_free_result($result);
	if ($_GET['archive']!='true' && $_GET['q']=='') {
	?>
	<form action="taskedit.php" method="post">
	<input type="hidden" name="job" value="<?php echo $_GET['id']; ?>" />
	<tr><td style="border-top: 2px solid white; background: white;"><input type="text" name="name" maxlength="50" value="" style="width: 100%;" /></td><td style="border-top: 2px solid white; background: white;"><select name="user">
	<?php
	$result = mysqli_query($link,'SELECT * FROM users;');
	while ($row = mysqli_fetch_array($result)) {
		echo '<option value="' . $row['name'] . '">' . $row['name'] . ' (' . $row['mail'] . ')</option>';
	}
	mysqli_free_result($result);
	?>
	</select></td><td style="border-top: 2px solid white; background: white;"><center><input type="submit" value="+"</center></td></tr>
	</form>
	<?php } ?>
	</table><br />
	<center><?php if ($_GET['archive']!='true') echo '<a href="task.php?archive=true&id=' . $_GET['id'] . '">Archive</a>'; else echo '<a href="task.php?id=' . $_GET['id'] . '">Back</a>'; ?></center>
	</div></div>
	<div class="ribbon"><div class="container">
	<?php require_once('menu.php'); ?>
	</div></div>
</body>

</html>
<?php
	mysqli_close($link);
	}
?>
