<?php

if ($usertype == 4) {
	
	if (isset($_POST['submit'])) {

		if (!empty($_POST['username'])) {

			$link = new DB();
			$query = "SELECT username FROM users WHERE username = ?";
			$result = $link->GetRow($query, [$_POST['username']]);

			if (!empty($result)) {
				$query2 = "UPDATE users SET usertype = -2 WHERE username = ?";
				$result2 = $link->UpdateRow($query2, [$_POST['username']]);

				if ($result2 == 1) {
					header ("Location: $home$lang".'/block-success');
				}
			}
		}
	}

	$output = "
		<h1>$c[block_member]</h1>
		<form action='' method='post'>
			$c[username]: <input type='text' name='username' class='field1' maxlength='20'><br><br>
			<input type='submit' name='submit' class='button1' value='$c[confirm]'>
		</form>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>