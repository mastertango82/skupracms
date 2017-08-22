<?php

if ($usertype == 0) {

	$error = Engine::Signin();
	

	$output = "
		<h1>$c[signin]</h1>
		<div class='block'>
			<form action='' method='post'>
			<p class='red'>$error</p>
			$c[username]:<br>
			<input type='text' name='username' maxlength='20' class='field1'><br><br>
			$c[password]:<br>
			<input type='password' name='password' maxlength='20' class='field1'><br><br>
			$c[remember]
			<input type='checkbox' name='remember' checked>
			<input type='submit' name='submit' class='button1' value='$c[confirm]'>
			</form>
		</div>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>