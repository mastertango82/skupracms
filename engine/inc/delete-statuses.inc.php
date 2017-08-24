<?php

if ($usertype > 2) {
	
	$frk = BasicConfig::$_prefix;
	$statuses = $frk.'statuses';

	if (isset($_POST['del_old'])) {

		$link = new DB();
		$query1 = "SELECT COUNT(*) FROM $statuses";
		$result1 = $link->GetRow($query1);

		$total = $result1['COUNT(*)'];
		
		if ($total > 10) {
			
			$limit = $total - 10;
		} else {
			
			$limit = 0;
		}

		$query2 = "DELETE FROM $statuses ORDER BY status_id ASC LIMIT $limit";
		$result2 = $link->DeleteRow($query2);

		if ($result2 > 0) {

			$output = "
				<h1>$c[delete_statuses]</h1>
				<p><b>$c[del_old_ok]</b></p>
			";
		} else {
			$output = "
				<h1>$c[delete_statuses]</h1>
				<p><b>$c[del_old_no]</b></p>
			";
		}
	} else if (isset($_POST['del_all'])) {

		$link = new DB();
		$query = "DELETE FROM $statuses";
		$result = $link->DeleteRow($query);

		if ($result > 0) {

			$output = "
				<h1>$c[delete_statuses]</h1>
				<p><b>$c[del_all_ok]</b></p>
			";
		} else {
			$output = "
				<h1>$c[delete_statuses]</h1>
				<p><b>$c[del_all_no]</b></p>
			";
		}
	} else if (isset($_POST['submit_stat'])) {

		$home = Config::$_home;

		$stat_id = $_POST['stat_id'];

		$link = new DB();
		$query = "DELETE FROM $statuses WHERE status_id = ?";
		$result = $link->DeleteRow($query, [$stat_id]);

		header("Location: ".$home.$lang.'/statuses');

	} else {

		$output = "
			<h1>$c[delete_statuses]</h1>
			<p class='red'>$c[warning]</p>
			<form action='' method='post'>
				<p>$c[del_stat_not]</p>
				<input type='text' name='stat_id' class='field3'>
				<input type='submit' name='submit_stat' class='button1' value='$c[confirm]'><br><br>
				<input type='submit' name='del_old' value='$c[del_old_s]' class='button1'>
				<input type='submit' name='del_all' value='$c[del_all_s]' class='button1'>
			</form>
		";
	}
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>