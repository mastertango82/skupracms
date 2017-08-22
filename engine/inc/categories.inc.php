<?php

$link = new DB();

$query = "SELECT * FROM categories";
$result = $link->GetRows($query);

if (empty($result)) {
	$output = "<h1>$c[no_content]</h1>";
} else {
	$lang = $_SESSION[$site]['userlang'];

	if ($_SESSION[$site]['userlang'] === 'sr-la' OR $_SESSION[$site]['userlang'] === 'sr-ci') {
		$cat_name = 'cat_name_sr';
		$cat_description = 'cat_description_sr';
	} else {
		$cat_name = 'cat_name_en';
		$cat_description = 'cat_description_en';
	}

	$content1 = "<h1>$c[categories]</h1>";

	$content2 = '';

	foreach($result as $cat) {
		$content2 .= "
			<div class='block2'>
				<h1><a href='".$home.$lang.'/category/'.$cat['cat_seo_name']."'>$cat[$cat_name] ($cat[num_art])</a></h1>
				<p>$cat[$cat_description]</p>
			</div>
		";
	}

	$output = $content1.$content2;
}

?>