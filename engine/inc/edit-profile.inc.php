<?php

if ($usertype > 0) {
	
	$result = Engine::Profile($_SESSION[$site]['userid']);
	$error = Engine::EditProfile();

	$output = "
		<h1>$c[edit_profile]</h1>
		<p class='red'>$error</p>
		<form action='' method='post' enctype='multipart/form-data'>
			$c[username]:<br>
			<input type='text' name='username' class='field1' value='$result[username]' maxlength='20'><br><br>
			$c[new_password]:<br>
			<input type='text' name='new_password' value='' class='field1' maxlength='20'><br><br>
			$c[name]:<br>
			<input type='text' name='name' class='field1' value='$result[name]' maxlength='20'><br><br>
			$c[lastname]:<br>
			<input type='text' name='lastname' class='field1' value='$result[lastname]' maxlength='20'><br><br>
			<input type='radio' name='gender' value='male' checked> $c[man]
  			<input type='radio' name='gender' value='female'> $c[woman]<br><br>
  			$c[birth]: 
  			<input type='text' name='birth' class='field3' maxlength='4' value='$result[birth]'><br><br>
			$c[signature]:<br>
			<input type='text' name='signature' class='field2' value='$result[signature]' maxlength='64'><br><br>
			$c[email]:<br>
			<input type='text' name='email' class='field2' value='$result[email]' maxlength='100'><br><br>
			$c[website1]:<br>
			<input type='text' name='website' class='field2' value='$result[website]' maxlength='100'><br><br>
			$c[description]:<br>
			<textarea name='description' class='textarea2' maxlength='190'>$result[description]</textarea><br><br>
			$c[avatar]: <input type='file' name='photo' size='25'><br><br>
			$c[language_def]:
			<select name='userlang' class='selbox1'>
				<option value='sr-ci'>$c[serbian_cy]</option>
				<option value='sr-la'>$c[serbian_la]</option>
				<option value='en'>$c[english]</option>
			</select><br><br>
			<input type='submit' name='submit' class='button1' value='$c[confirm]'>
		</form>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>