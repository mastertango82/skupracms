<?php

if ($usertype == 4) {
	
	$frk = BasicConfig::$_prefix;
	$blocked = $frk.'blocked';

	$output = "<h1>$c[block_ip]</h1>";

	if (isset($_POST['block'])) {

		$ip = $_POST['ip'];

		$link = new DB();
		$query = "INSERT INTO $blocked (ip) VALUES (?)";
		$result = $link->InsertRow($query, [$ip]);
	}

	if (isset($_POST['unblock'])) {

		$ip = $_POST['ip'];

		$link = new DB();
		$query = "DELETE FROM $blocked WHERE ip = ?";
		$result = $link->UpdateRow($query, [$ip]);
	}

	$output .= "
		<form action='' method='post'>
			$c[ban]:
			<input type='text' name='ip' class='field1' maxlength='32'>
			<input type='submit' name='block' class='button1' value='$c[confirm]'>
		</form>
		<br>
	";

	$output .= "
		<form action='' method='post'>
			$c[unblock]:
			<input type='text' name='ip' class='field1' maxlength='32'>
			<input type='submit' name='unblock' class='button1' value='$c[confirm]'>
		</form>
		<br><br>
	";

	$link = new DB();
	$query = "SELECT * FROM $blocked";
	$result = $link->GetRows($query);

	if (!empty($result)) {

		foreach ($result as $user) {

			$output .= "<p>$c[block_ip_yes]: <b>$user[ip]</b></p>";
		}
	} else {
		
		$output .= "<p><b>$c[block_ip_not]</b></p>";
	}
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>