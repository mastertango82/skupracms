<?php

if ($usertype == 4) {

	$link = new DB();

	$query0 = "SELECT COUNT(*) FROM comments";
	$result0 = $link->GetRow($query0);
	$total = ($result0['COUNT(*)']);
	$limit = parent::$_limit_comments;

	$page = isset($_GET['content2']) ? $_GET['content2'] : 1;
	$start = $limit * ($page-1);
	$num_page = ceil($total/$limit);

	$query = "SELECT * FROM comments LIMIT $start, $limit";
	$result = $link->GetRows($query);

	if (empty($result)) {

		$output = "<h1>$c[no_comments]</h1>";
	} else {
		
		$output = "
			<h1>$c[delete_comments]</h1>
		";
		
		foreach ($result as $comment) {

			$output .= "<p>$comment[com_id] | <b>$comment[userip]</b> | $comment[comment]</p>";
		}
	
		if (isset($_POST['delete_com'])) {

			$com_id = $_POST['com_id'];

			Engine::DeleteComm($com_id);
		}

		$output .= "
			<br>
			<br>
			<p>$c[com_notice]</p>
			<form action='' method='post'>
				<input type='text' name='com_id' class='field3'>
				<input type='submit' name='delete_com' class='button1' value='$c[confirm]'>
			</form>
		";
	}

	$output .= Engine::Pagination($page, $num_page, '');
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>