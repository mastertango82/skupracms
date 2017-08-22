<?php

if ($content1 == 'all-articles') {

	$output = "<div id='right'><h1>$c[archives]</h1>";

	$link = new DB();

	$frk = BasicConfig::$_prefix;
	$articles = $frk.'articles';

	$query = "SELECT year(odate_ar) AS year, month(odate_ar) AS month, COUNT(*) AS total FROM $articles WHERE publish = ? GROUP BY year, month ORDER BY year DESC, month";
	$result = $link->GetRows($query, [1]);

	$currentyear = null;

	foreach($result as $d){            
		
		if ($d['month'] == 1) {
			
			$month_d = $c['jan'];
		} else if ($d['month'] == 2) {
			
			$month_d = $c['feb'];
		} else if ($d['month'] == 3) {
			
			$month_d = $c['mar'];
		} else if ($d['month'] == 4) {
			
			$month_d = $c['apr'];
		} else if ($d['month'] == 5) {
			
			$month_d = $c['maj'];
		} else if ($d['month'] == 6) {
			
			$month_d = $c['jun'];
		} else if ($d['month'] == 7) {
			
			$month_d = $c['jul'];
		} else if ($d['month'] == 8) {
			
			$month_d = $c['avg'];
		} else if ($d['month'] == 9) {
			
			$month_d = $c['sep'];
		} else if ($d['month'] == 10) {
			
			$month_d = $c['okt'];
		} else if ($d['month'] == 11) {
			
			$month_d = $c['nov'];
		} else if ($d['month'] == 12) {
			
			$month_d = $c['dec'];
		}

		if ($currentyear != $d['year']){
			$output .= "<h2>".$d['year']."</h2><p>";
			$currentyear = $d['year'];
		}

		$output .= "<p><a href='".$home.$lang.'/archive-for/'.$d['year'].'/'.$d['month']."'>$month_d | $d[total]</a></p>";
	}

	$output .= "</div>";
} else {

	$output = '';
}


?>