<?php

if ($usertype > 2) {

	if (isset($_GET['content2'])) {

		$link = new DB();

		$query = "DELETE FROM categories WHERE num_art = ? AND cat_id = ?";
		$result = $link->DeleteRow($query, [0, $_GET['content2']]);

		if ($result > 0) {
			header("Location: $home$lang".'/delete-category');
		}
	}

	$link = new DB();
	$query = "SELECT * FROM categories ORDER BY cat_id ASC";
	$result = $link->GetRows($query);

	$output = "<h1>$c[delete_cat]</h1>";
	$output .= "<p><b>$c[del_cat_notice]</b></p>";

	if ($_SESSION[$site]['userlang'] === 'sr-ci' OR $_SESSION[$site]['userlang'] === 'sr-la') {

		$cat_name = 'cat_name_sr';
	} else {
		$cat_name = 'cat_name_en';
	}

	foreach ($result as $cat) {

		$output .= "<p>$c[category]: <a href='".$home.$lang.'/delete-category/'.$cat['cat_id']."'><b>$cat[$cat_name] ($cat[num_art])</b></a></p>";
	}
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>