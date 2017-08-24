<?php

require '../errors.php';
require_once '../basic-config.php';

require_once 'engine/classes/Session.class.php';
require_once 'engine/classes/Installation.class.php';

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
	<h3><?php echo $l['step_3']; ?></h3>
	<p><?php echo $l['db_p2']; ?></p>
		<form action='' method='post'>
			<p><?php echo $submit; ?></p>
			<?php echo $l['host']; ?>
			<input type='text' name='host' value='localhost' maxlength='20'><br><br>
			<?php echo $l['dbuser']; ?>
			<input type='text' name='dbuser' maxlength='20'><br><br>
			<?php echo $l['dbpass']; ?>
			<input type='text' name='dbpass' maxlength='20'><br><br>
			<?php echo $l['dbname']; ?>
			<input type='text' name='dbname' maxlength='20'><br><br>
			<?php echo $l['dbprefix']; ?>
			<input type='text' name='dbprefix' value='sk_' maxlength='3'><br><br>
			<p>
				<?php echo "<a href='step2'>$l[step_2]</a>"; ?>
				<input type='submit' name='step3' value='<?php echo $l['step_4']; ?>'>
			</p>
		</form>
	</div>
</body>
</html>