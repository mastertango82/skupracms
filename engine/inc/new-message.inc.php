<?php

if ($usertype > 2) {
	
	$error = '';

	if (isset($_POST['submit'])) {
		
		$message_sr = htmlspecialchars ($_POST['message_sr'], ENT_QUOTES);
		$message_en = htmlspecialchars ($_POST['message_en'], ENT_QUOTES);

		$error = Engine::NewMessage($message_sr, $message_en);
	}

	$output = "
		<h1>$c[new_message]</h1>
		<p class='red'>$error</p>
		<form action='' method='post'>
			$c[message_sr]:<br>
			<input type='text' name='message_sr' class='field2' maxlength='190'><br><br>
			$c[message_en]:<br>
			<input type='text' name='message_en' class='field2' maxlength='190'><br><br>
			<input type='submit' name='submit' value='$c[confirm]' class='button1'>
		</form>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>