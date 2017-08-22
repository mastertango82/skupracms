<?php

if ($usertype > 3) {
	
	$error = '';

	if (isset($_POST['del_all'])) {

		$error = Engine::DeleteMessages('del_all');
	}
	if (isset($_POST['del_old'])) {

		$error = Engine::DeleteMessages('del_old');
	}
	if (isset($_POST['submit_mess'])) {

		$mess_id = $_POST['mess_id'];

		$error = Engine::DeleteMessages($mess_id);
	}

	$output = "
		<h1>$c[delete_messages]</h1>
		<p class='red'>$error</p>
		<p class='red'>$c[warning]</p>
		<form action='' method='post'>
			<p>$c[del_mess_not]</p>
			<input type='text' name='mess_id' class='field3'>
			<input type='submit' name='submit_mess' class='button1' value='$c[confirm]'><br><br>
			<input type='submit' name='del_old' value='$c[del_old]' class='button1'>
			<input type='submit' name='del_all' value='$c[del_all]' class='button1'>
		</form>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>