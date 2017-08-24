<?php

if ($usertype > 0) {
	
	$frk = BasicConfig::$_prefix;
	$pmessages = $frk.'pmessages';

	$output = "
		<h1>$c[messages]</h1>
		<p class='small'>($c[mess_notice])</p>
	";

	if ($usertype == 4) {
		
		Engine::DeletePrivateMessages();

		$output .= "
			<form action='' method='post'>
				<input type='submit' name='delete' value='$c[delete_mess]' class='button1'>
			</form>
		";
	}

	$error = '';

	$link = new DB();

	if (isset($_POST['submit'])) {

		if (empty($_POST['receiver']) OR empty($_POST['message'])) {
			$output .= "<p class='red'>$c[empty_mess]</p>";
		} else {

			$error = Engine::SendMessage($_POST['receiver'], $_POST['message']);
		}
	}

	$output .= "
		<form action='' method='post'>
			<p class='red'>$error</p>
			$c[add_rece]:<br>
			<input type='text' name='receiver' class='field1' maxlength='20'><br><br>
			$c[add_mess]:<br>
			<input type='text' name='message' class='field2' maxlength='150'>
			<input type='submit' name='submit' value='$c[confirm]' class='button1'>
		</form>
	";

	$query1 = "SELECT * FROM $pmessages WHERE sender = ? OR receiver = ? ORDER BY message_id DESC LIMIT 30";
	
	$user = Engine::UserId($_SESSION[$site]['username']);

	$result1 = $link->GetRows($query1, [$user, $user]);
	
	foreach ($result1 as $m) {
		
		$sender = Engine::UserFromId($m['sender']);
		$receiver = Engine::UserFromId($m['receiver']);
		$output .= "<p><b>$m[date_time]</b> | $c[sender] <b>$sender</b> | $c[receiver] <b>$receiver</b> | <b>$m[message]</b></p>";	
	}
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>