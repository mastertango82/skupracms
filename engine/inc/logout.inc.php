<?php

if ($usertype > 0) {
	
	if (isset($_COOKIE[$site])) {
		setcookie($site, '', time()-3600*24*30, '/');
	}
	session_destroy();

	header("Location: $home");
	exit();
	//
} else {
	$output = "<h1>$c[protected]</h1>";
}

?>