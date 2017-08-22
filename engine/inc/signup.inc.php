<?php

if ($usertype == 0) {
	
	$errors = '';
	$errors = Engine::Signup();

	$output = "
		<h1>$c[signup]</h1>
		<div class='block'>
			<form action='' method='post'>
			<p class='red'>$errors</p>
			$c[username]:<br>
			<input type='text' name='username' maxlength='20' class='field1'><br><br>
			$c[password]:<br>
			<input type='password' name='password' maxlength='20' class='field1'><br><br>
			$c[password_again]:<br>
			<input type='password' name='password_again' maxlength='20' class='field1'><br><br>
			$c[email]:<br>
			<input type='text' name='email' maxlength='64' class='field1'><br><br>
			<input type='radio' name='gender' value='male' checked> $c[man]
	  		<input type='radio' name='gender' value='female'> $c[woman]<br><br>
			<input type='submit' name='submit' class='button1' value='$c[confirm]'>
			</form>
		</div>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>