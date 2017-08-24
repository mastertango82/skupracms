<?php

if ($usertype > 0) {
	
	$link = new DB();

	$frk = BasicConfig::$_prefix;
	$linemessages = $frk.'linemessages';

	$query = "SELECT COUNT(*) FROM $linemessages";
	$result0 = $link->GetRow($query);
	
	$total = ($result0['COUNT(*)']);
	$limit = parent::$_limit_linemessages;
	$page = isset($_GET['content2']) ? $_GET['content2'] : 1;
	
	$start = $limit * ($page-1);
	$num_page = ceil($total/$limit);

	$output = "
		<h1>$c[all_messages]</h1>
	";

	$query1 = "SELECT * FROM $linemessages LIMIT $start, $limit";
	$result1 = $link->GetRows($query1);

	foreach ($result1 as $r) {
		
		$output .= "
			<p>
				$r[message_id] | $r[message_date] | <b>$r[message_sr]</b> | $r[message_en]
			</p>
		";
	}

	if ($usertype > 2) {

		if (isset($_POST['submit'])) {

			$mess = $_POST['mess'];

			Engine::UpdateLineMessages($mess);
		}

		$output .= "
			<br>
			<p>$c[all_mess_notice]</p>
			<form action='' method='post'>
			<input type='text' name='mess' class='field3'>
			<input type='submit' name='submit' class='button1' value='$c[confirm]'>
			</form>
		";
	}
	
	$output .= Engine::Pagination($page, $num_page, '');
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>