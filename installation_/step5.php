<?php

require '../errors.php';
require_once '../basic-config.php';

require_once 'engine/classes/Session.class.php';
require_once 'engine/classes/Installation.class.php';
require_once 'engine/classes/DB.class.php';

$session = new Session();

$create = Installation::Create();

$submit = Installation::Submit();

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
	<h3><?php echo $l['step_5']; ?></h3>
	<p><?php echo $create; ?></p>
		<p>
			<?php echo "<a href='step6'>$l[step_6]</a>"; ?>
		</p>
	</div>
</body>
</html>