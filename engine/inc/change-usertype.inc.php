<?php

if ($usertype == 4) {
	
	$e = Language::LangPart('edit');
	$error = '';

	if (isset($_POST['submit'])) {
		$username = htmlspecialchars ($_POST['username'], ENT_QUOTES);

		if (!empty($_POST['username'])) {

			$link = new DB();
			$query = "SELECT username FROM users WHERE username = ?";
			$result = $link->GetRow($query, [$username]);

			if (!empty($result)) {
				$query2 = "UPDATE users SET usertype = ? WHERE username = ?";
				$result2 = $link->UpdateRow($query2, [$_POST['usertype'], $username]);

				if ($result2 == 1) {
					header ("Location: $home$lang".'/change-usertype-success');
				} else {
					$error = $e['usert_no_chang'];
				}
			} else {
				$error = $e['no_user'];
			}
		} else {
			$error = $e['enter_us'];
		}
	}

	$output = "
		<h1>$c[change_usertype]</h1>
		<p class='red'>$error</p>
		<form action='' method='post'>
			$c[username]:<br>
			<input type='text' name='username' class='field1' maxlength='20'><br><br>
			$c[let_it_be]&nbsp;
			<select name='usertype' class='selbox1'>
				<option value='1'>$c[member]</option>
				<option value='2'>$c[author]</option>
				<option value='3'>$c[moderator]</option>
				<option value='4'>$c[administrator]</option>
			</select><br><br>
			<input type='submit' name='submit' value='$c[confirm]' class='button1'>
		</form>
	";	
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>