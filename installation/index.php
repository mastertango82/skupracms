<?php

require '../errors.php';
require_once '../basic-config.php';

require_once 'engine/classes/Session.class.php';
require_once 'engine/classes/Installation.class.php';

$session = new Session();

$submit = Installation::Submit();

$options = Installation::Options();

$check = Installation::Check();

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
	<h3><?php echo $l['step_1']; ?></h3>
	<p><?php echo $l['lang_p']; ?></p>
	<form action='' method='post'>
		<?php echo $l['lang']; ?>
		<select name='lang'>
			<?php echo $options; ?>
		</select>
		<input type='submit' name='sublang' value='<?php echo $l['pick']; ?>'>
	</form>
		<p><?php echo $l['check']; ?></p>
		<p>
			<?php echo $check['mod']."<br>".$check['config']; ?>
		</p>
			<?php 
				if ($check['step_mod'] == 1 AND $check['step_config'] == 1) {
					echo "<p><a href='step2'>$l[step_2]</a></p>";
				}
			?>	
	
	</div>
</body>
</html>