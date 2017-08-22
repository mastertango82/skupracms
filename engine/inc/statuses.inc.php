<?php

if (isset($_POST['submit'])) {

	$status = htmlspecialchars($_POST['status'], ENT_QUOTES);

	$date_time = date("d.m.Y - H:i");

	if (!empty($status)) {
		if ($usertype == 0) {
			if ($_SESSION[$site]['var']['result'] == $_POST['result']) {
				
				$add_status = Engine::AddStatus($date_time, $status);
				header("Location: $home$lang".'/statuses');
			}	
		} else {
			
			$add_status = Engine::AddStatus($date_time, $status);
			header("Location: $home$lang".'/statuses');
		}
	}
}

$link = new DB();
$query = "SELECT * FROM statuses ORDER BY status_id DESC LIMIT 20";
$result = $link->GetRows($query);

$content_0 = "<h1>$c[statuses]</h1>";

if ($usertype > 0) {

	$content_2 = "
		<form action='' method='post'>
			$c[add_status]:<br>
			<input type='text' name='status' class='field2' maxlength='150'>
			<input type='submit' name='submit' value='$c[confirm]' class='button1'>
		</form>
	";
} else {

	$o1 = rand (0, 5);
	$o2 = rand (0, 5);
	
	$_SESSION[$site]['var']['result'] = $o1 + $o2;

	$content_2 = "
		<form action='' method='post'>
			$c[add_status]:<br>
			<input type='text' name='status' class='field2' maxlength='150'><br>
			$o1 + $o2 = <input type='text' name='result' maxlength='2' class='field3'>
			<input type='submit' name='submit' value='$c[confirm]' class='button1'>
		</form>
	";
}

$content_3 = '';

if ($usertype == 4) {
	
	foreach ($result as $status) {
		$content_3 .= "<p><b>$status[status_id]</b> | $status[userip] | $status[date_time] | $status[username]: <b>$status[status]</b></p>";
	}
} else {
	
	foreach ($result as $status) {
		$content_3 .= "<p>$status[date_time] | $status[username]: <b>$status[status]</b></p>";
	}
}

$output = $content_0.$content_2.$content_3;

?>