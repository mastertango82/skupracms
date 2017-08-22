<?php

if ($usertype == 0) {
	
	$error = Engine::Forgot();

	$output = "
		<h1>$c[forgot]</h1>
		<div class='block'>
			<p>$c[forgot_notice]</p>
			<form action='' method='post'>
			<p class='red'>$error</p>
			$c[email]:<br>
			<input type='text' name='email' maxlength='64' class='field1'><br><br>
			<input type='submit' name='submit' class='button1' value='$c[confirm]'>
			</form>
		</div>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>