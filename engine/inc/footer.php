<?php

$link = new DB();

$frk = BasicConfig::$_prefix;
$categories = $frk.'categories';
$articles = $frk.'articles';

$query = "SELECT * FROM $articles JOIN $categories ON $articles.category_id = $categories.cat_id AND $articles.footer = ? AND publish = ?";
$result = $link->GetRows($query, [1, 1]);

if ($_SESSION[$site]['userlang'] === 'sr-la' OR $_SESSION[$site]['userlang'] === 'sr-ci') {

	$header = 'header_sr';
	$myworks = 'Моји радови';
} else {
	
	$header = 'header_en';
	$myworks = 'My works';
}

$article = '';

foreach ($result as $r) {

	$article .= "<a href='".$home.$lang.'/'.$r['cat_seo_name'].'/'.$r['seo']."'>$r[$header]</a>";
}

$article .= "<a href='".$home.$lang.'/myworks'."'>$myworks</a>";

$output = "
	<p>$article</p>
	<p id='minif'>$c[copycopy]</p>
";

?>