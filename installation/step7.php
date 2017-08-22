<?php

require '../errors.php';
require '../basic-config.php';

require_once 'engine/classes/Session.class.php';
require_once 'engine/classes/Installation.class.php';
require_once 'engine/classes/DB.class.php';

$session = new Session();

require '../languages/'.$_SESSION['language'].'/installation.php';

?>

<!doctype html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link rel='icon' type='image/png' href='../favicon.png'>
	<link rel='stylesheet' type='text/css' href='../look/css/installation.css'>
	<title><?php echo $l['title']; ?></title>
</head>

<body>
	<div id='install'>
	<img src='../look/img/logo-black.png'>
	<h1><?php echo $l['title']; ?></h1>
	<h3><?php echo $l['step_7']; ?></h3>
	<p><?php echo $l['end']; ?></p>
	<p>
		<?php echo $l['username']."<b>".$_SESSION['username']."</b><br>"; ?>
		<?php echo $l['password']."<b>".$_SESSION['password']."</b>"; ?>
	</p>
	</div>
</body>
</html>