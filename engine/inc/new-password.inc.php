<?php

if ($usertype == 0) {
	
	$error = '';
	$error = Engine::NewPassword();

	$output = "
		<div class='block'>
			<h1>$c[new_password_guest]</h1>
			<form action='' method='post' class='form1'>
			<p class='red'>$error</p>
			$c[password]:<br>
			<input type='password' name='password' maxlength='20' class='field1'><br><br>
			<input type='submit' name='submit' class='button1' value='$c[confirm]'>
			</form>
		</div>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>