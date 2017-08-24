<?php

if (isset($_GET['content2'])) {

	if ($userlang == 'en') {
		
		$cat_name = 'cat_name_en';
	} else {

		$cat_name = 'cat_name_sr';
	}

	$link = new DB();

	$frk = BasicConfig::$_prefix;
	$categories = $frk.'categories';
	$articles = $frk.'articles';
	$users = $frk.'users';
	$comments = $frk.'comments';

	$query0 = "SELECT * FROM $articles JOIN $categories ON $articles.category_id = $categories.cat_id AND $categories.cat_seo_name = ? AND publish = ?";

	$result0 = $link->GetRow($query0, [$_GET['content2'], 1]);
	$total = ($result0['num_art']);

	$limit = parent::$_limit_articles_from;

	$page = isset($_GET['op1']) ? $_GET['op1'] : 1;

	$start = $limit * ($op1-1);

	$num_page = ceil($total/$limit);

	$category = $_GET['content2'];

	if (!empty($result0)) {

		if (isset($_GET['page']) AND $_GET['page'] === 'like') {
			
			$order_notice = $c['order_like_ar'];
			$query = "SELECT * FROM $articles JOIN $users ON $articles.author_id = $users.userid JOIN $categories ON $articles.category_id = $categories.cat_id AND $categories.cat_seo_name = ? AND publish = ? ORDER BY like_article DESC LIMIT $start, $limit";
		} else if (isset($_GET['page']) AND $_GET['page'] === 'dislike') {
			
			$order_notice = $c['order_dislike_ar'];
			$query = "SELECT * FROM $articles JOIN $users ON $articles.author_id = $users.userid JOIN $categories ON $articles.category_id = $categories.cat_id AND $categories.cat_seo_name = ? AND publish = ? ORDER BY dislike_article DESC LIMIT $start, $limit";
		} else if (isset($_GET['page']) AND $_GET['page'] === 'old') {
			
			$order_notice = $c['order_old_ar'];
			$query = "SELECT * FROM $articles JOIN $users ON $articles.author_id = $users.userid JOIN $categories ON $articles.category_id = $categories.cat_id AND $categories.cat_seo_name = ? AND publish = ? ORDER BY article_id ASC LIMIT $start, $limit";
		} else {
			
			$order_notice = $c['order_new_ar'];
			$query = "SELECT * FROM $articles JOIN $users ON $articles.author_id = $users.userid JOIN $categories ON $articles.category_id = $categories.cat_id AND $categories.cat_seo_name = ? AND publish = ? ORDER BY article_id DESC LIMIT $start, $limit";
		}

		$result = $link->GetRows($query, [$_GET['content2'], 1]);



		if (!empty($result)) {

			$output = "
				<div class='dropdown2' style='float:right;'>
					<button class='dropbtn2'>$c[order]</button>
					<div class='dropdown-content2'>
						<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/new/'.$op1."'>$c[ord_new]</a>
						<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/like/'.$op1."'>$c[ord_like]</a>
						<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/dislike/'.$op1."'>$c[ord_dislike]</a>
						<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/old/'.$op1."'>$c[ord_old]</a>
					</div>
				</div>
				<h2 class='head'>$c[category]: $result0[$cat_name]</h2>
				<p class='info'>$order_notice</p>
				<div class='clear'></div>
			";

			require_once 'engine/js/article.php';
			$content1 = $js;
			
			foreach ($result as $article) {
				
				$query2 = "SELECT COUNT(*) as total FROM $comments WHERE artic_id = ?";
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
				
				$string = mb_substr(strip_tags($article[$body], '<img>'), 0, 500, 'utf-8');

				if (strpos($string, '<img') !== false) {
				    
				    $string = $string;
				} else {
					
					$string = mb_substr(strip_tags($article[$body], '<img>'), 0, 600, 'utf-8');
				}

				require 'engine/scripts/art_header.php';
				
				if ($article['cat_seo_name'] == 'preuzimanja' OR $article['cat_seo_name'] == 'slusalica') {

					$content1 .= "
						<div class='block'>
							$art_header
							</p>
							$article[$body]
						</div>
					";
				} else {

					$content1 .= "
						<div class='block2'>
							$art_header
							</p>
							".$string. "...<a class='read-more' href='".$home.$lang.'/'.$article['cat_seo_name'].'/'.$article['seo']."'>$c[read_more]</a>
							<div class='space'></div>
						</div>
					";
				}
			}

			$pagi = Engine::Pagination($page, $num_page, $category);

			$output .= $content1.$pagi;
		} else {
			
			$output = "<h1>$c[no_content]</h1>";
		}
	} else {
		
		$output = "<h1>$c[no_content]</h1>";
	}
} else {
	
	$output = "<h1>$c[no_content]</h1>";
}

?>