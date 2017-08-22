<?php

if ($content1 == 'all-articles') {

	if ($userlang == 'en') {

		$catname = 'cat_name_en';
	} else {
		$catname = 'cat_name_sr';
	}

	$output = "<div id='left'><h1>$c[categories]</h1>";

	$link = new DB();

	$frk = BasicConfig::$_prefix;
	$categories = $frk.'categories';

	$query = "SELECT * FROM $categories";
	$result = $link->GetRows($query);

	foreach ($result as $cat) {

		$output .= "<p><a href='".$home.$lang.'/category/'.$cat['cat_seo_name']."'>$cat[$catname] | $cat[num_art]</a></p>";
	}

	$output .= "</div>";
} else {

	$output = '';
}


?>