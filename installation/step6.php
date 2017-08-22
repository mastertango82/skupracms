<?php

require '../errors.php';
require_once '../basic-config.php';

require_once 'engine/classes/Session.class.php';
require_once 'engine/classes/Installation.class.php';
require_once 'engine/classes/DB.class.php';

$session = new Session();

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
	<h3><?php echo $l['step_6']; ?></h3>
	<p><?php echo $l['adm_p']; ?></p>
		<form action='' method='post'>
			<p><?php echo $submit; ?></p>
			<?php echo $l['username']; ?>
			<input type='text' name='username' value='Administrator' maxlength='20'><br><br>
			<?php echo $l['password']; ?>
			<input type='text' name='password' maxlength='20'><br><br>
			<p>
				<input type='submit' name='submit_6' value='<?php echo $l['step_7']; ?>'>
			</p>
		</form>
	</div>
</body>
</html>