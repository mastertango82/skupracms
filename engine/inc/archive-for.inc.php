<?php

$link = new DB();

$query0 = "SELECT COUNT(*) FROM articles WHERE year(odate_ar) = ? AND month(odate_ar) = ? AND publish = ?";
$result0 = $link->GetRow($query0, [$content2, $page, 1]);
$total = ($result0['COUNT(*)']);

$limit = parent::$_limit_articles_arc;

$start = $limit * ($op2-1);

$num_page = ceil($total/$limit);

$category = 'archive';

if (isset($_GET['op1']) AND $_GET['op1'] === 'like') {
	
	$order_notice = $c['order_like_ar'];
	$query = "SELECT * FROM articles JOIN users ON articles.author_id = users.userid JOIN categories ON articles.category_id = categories.cat_id AND year(odate_ar) = ? AND month(odate_ar) = ? AND publish = ? ORDER BY like_article DESC LIMIT $start, $limit";
} else if (isset($_GET['op1']) AND $_GET['op1'] === 'dislike') {
	
	$order_notice = $c['order_dislike_ar'];
	$query = "SELECT * FROM articles JOIN users ON articles.author_id = users.userid JOIN categories ON articles.category_id = categories.cat_id AND year(odate_ar) = ? AND month(odate_ar) = ? AND publish = ? ORDER BY dislike_article DESC LIMIT $start, $limit";
} else if (isset($_GET['op1']) AND $_GET['op1'] === 'old') {
	
	$order_notice = $c['order_old_ar'];
	$query = "SELECT * FROM articles JOIN users ON articles.author_id = users.userid JOIN categories ON articles.category_id = categories.cat_id AND year(odate_ar) = ? AND month(odate_ar) = ? AND publish = ? ORDER BY article_id ASC LIMIT $start, $limit";
} else {
	
	$order_notice = $c['order_new_ar'];
	$query = "SELECT * FROM articles JOIN users ON articles.author_id = users.userid JOIN categories ON articles.category_id = categories.cat_id AND year(odate_ar) = ? AND month(odate_ar) = ? AND publish = ? ORDER BY article_id DESC LIMIT $start, $limit";
}

$result = $link->GetRows($query, [$content2, $page, 1]);

if (!empty($result)) {

	$output = "
		<div class='dropdown2' style='float:right;'>
			<button class='dropbtn2'>$c[order]</button>
			<div class='dropdown-content2'>
				<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/'.$page.'/new/'.$op2."'>$c[ord_new]</a>
				<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/'.$page.'/like/'.$op2."'>$c[ord_like]</a>
				<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/'.$page.'/dislike/'.$op2."'>$c[ord_dislike]</a>
				<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/'.$page.'/old/'.$op2."'>$c[ord_old]</a>
			</div>
		</div>
		<h2 class='head'>$c[archives]</h2>
		<p class='info'>$order_notice</p>
		<div class='clear'></div>
	";

	require_once 'engine/js/article.php';
	$content1 = $js;

	foreach ($result as $article) {

		$query2 = "SELECT COUNT(*) as total FROM comments WHERE artic_id = ?";
		$total = $link->GetRow($query2, [$article['article_id']]);
		$total = $total['total'];
		
		$adate = explode('-', $article['odate_ar']);
		$adate = $adate[2].'.'.$adate[1].'.'.$adate[0];
		
		if ($article['multi_lang'] == 1 AND $userlang == 'en') { 

			$body = 'body_en';
		} else {
			
			$body = 'body_sr';
		}	
		
		if ($userlang == 'en') {
				
			$cat = 'cat_name_en';
			$header = 'header_en';
		} else {
			
			$cat = 'cat_name_sr';
			$header = 'header_sr';
		}

		require 'engine/scripts/art_header.php';
		
		$content1 .= "
			<div class='block'>
				$art_header
				</p>
				$article[$body]
			</div>
		";
	}

	$pagi = Engine::Pagination($op2, $num_page, $category);

	$output .= $content1.$pagi;
} else {
	
	$output = "<h1>$c[no_content]</h1>";
}

?>