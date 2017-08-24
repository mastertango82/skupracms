<?php

if ($usertype == 4) {
	
	$frk = BasicConfig::$_prefix;
	$users = $frk.'users';

	$output = "
		<h1>$c[delete_member]</h1>
		<p>$c[delete_member_not]</p>

		<form action='' method='post'>
		$c[member]: 
		<input type='text' name='mem' class='field1'>
		<input type='submit' name='submit' class='button1' value='$c[confirm]'>
		</form>
	";

	if (isset($_POST['submit'])) {
		
		$username = $_POST['mem'];

		$link = new DB();
		$query = "SELECT * FROM $users WHERE username = ? AND num_art = ?";
		$result = $link->GetRow($query, [$username, 0]);

		if (!empty($result)) {

			$query2 = "UPDATE $users SET usertype = ? WHERE username = ?";
			$result2 = $link->UpdateRow($query2, [-3, $username]);

			if ($result2 == 1) {

				header("Location: $home$lang".'/delete-member-success');
			}
		} else {

			$output .= "<p class='red'>$c[no_del_mem]</p>";
		}
	}
} else {

	$output = "<h1>$c[protected]</h1>";
}

?>