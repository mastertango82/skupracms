<?php

if ($usertype == 0) {
	
	$error = '';
	$error = Engine::Activation();

	$output = "
		<div class='block'>
			<h1>$c[activation]</h1>
			<p class='red'>$error</p>
		</div>
	";
}

?>