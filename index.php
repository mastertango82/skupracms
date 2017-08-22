<?php

require_once 'errors.php';

if (is_dir('installation')) {
	
	header("Location: installation");
	exit();
} else {

	require_once 'basic-config.php';
	require_once 'extra-config.php';
	require_once 'engine/classes/Content.class.php';
	require_once 'engine/classes/Decode.class.php';
	require_once 'engine/classes/Language.class.php';
	require_once 'engine/classes/Session.class.php';
	require_once 'engine/classes/DB.class.php';
	require_once 'engine/classes/Engine.class.php';

	$session = new Session();
	$session->Start();

	$lang = new Language();

	$content = new Content();

	$decode = new Decode;
	echo $decode->Output();
}

?>