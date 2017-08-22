<?php

if ($usertype > 0) {

	if (isset($_GET['content2'])) {

		$link = new DB();

		$query = "SELECT userid, username, COUNT(*) FROM articles JOIN users ON articles.author_id = users.userid JOIN categories ON articles.category_id = categories.cat_id AND cat_seo_name != ? AND cat_seo_name != ? AND articles.author_id = ? AND publish = ?";

		$result = $link->GetRow($query, ['slusalica', 'preuzimanja', $_GET['content2'], 1]);
		$total = ($result['COUNT(*)']);

		$limit = parent::$_limit_articles_from;

		$page = isset($_GET['op1']) ? $_GET['op1'] : 1;
		
		$start = $limit * ($op1-1);

		$num_page = ceil($total/$limit);

		if (isset($_GET['page']) AND $_GET['page'] === 'like') {
			
			$order_notice = $c['order_like_ar'];
			$query2 = "SELECT * FROM articles JOIN categories ON articles.category_id = categories.cat_id JOIN users ON articles.author_id = users.userid AND cat_seo_name != ? AND cat_seo_name != ? AND users.userid = ? AND publish = ? ORDER BY like_article DESC LIMIT $start, $limit";
		} else if (isset($_GET['page']) AND $_GET['page'] === 'dislike') {

			$order_notice = $c['order_dislike_ar'];
			$query2 = "SELECT * FROM articles JOIN categories ON articles.category_id = categories.cat_id JOIN users ON articles.author_id = users.userid AND cat_seo_name != ? AND cat_seo_name != ? AND users.userid = ? AND publish = ? ORDER BY dislike_article DESC LIMIT $start, $limit";
		} else if (isset($_GET['page']) AND $_GET['page'] === 'old') {

			$order_notice = $c['order_old_ar'];
			$query2 = "SELECT * FROM articles JOIN categories ON articles.category_id = categories.cat_id JOIN users ON articles.author_id = users.userid AND cat_seo_name != ? AND cat_seo_name != ? AND users.userid = ? AND publish = ? ORDER BY article_id ASC LIMIT $start, $limit";
		} else {

			$order_notice = $c['order_new_ar'];
			$query2 = "SELECT * FROM articles JOIN categories ON articles.category_id = categories.cat_id JOIN users ON articles.author_id = users.userid AND cat_seo_name != ? AND cat_seo_name != ? AND users.userid = ? AND publish = ? ORDER BY article_id DESC LIMIT $start, $limit";
		}

		$result2 = $link->GetRows($query2, ['slusalica', 'preuzimanja', $_GET['content2'], 1]);

		$content_1 = "
			<div class='dropdown2' style='float:right;'>
				<button class='dropbtn2'>$c[order]</button>
				<div class='dropdown-content2'>
					<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/new/'.$op1."'>$c[ord_new]</a>
					<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/like/'.$op1."'>$c[ord_like]</a>
					<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/dislike/'.$op1."'>$c[ord_dislike]</a>
					<a href='".$home.$lang.'/'.$content1.'/'.$content2.'/old/'.$op1."'>$c[ord_old]</a>
				</div>
			</div>
			<h2 class='head'>$c[articles_from]: $result[username]</h2>
			<p class='info'>$order_notice</p>
			<div class='clear'></div>
		";

		require_once 'engine/js/article.php';
		$content_2 = $js;
		
		if (!empty($result2)) {	
			
			foreach ($result2 as $article) {

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
				
				$string = mb_substr(strip_tags($article[$body], '<img>'), 0, 500, 'utf-8');

				if (strpos($string, '<img') !== false) {
				    
				    $string = $string;
				} else {
					
					$string = mb_substr(strip_tags($article[$body], '<img>'), 0, 600, 'utf-8');
				}

				require 'engine/scripts/art_header.php';
				
				$content_2 .= "
					<div class='block2'>
						$art_header
						</p>
						".$string. "...<a class='read-more' href='".$home.$lang.'/'.$article['cat_seo_name'].'/'.$article['seo']."'>$c[read_more]</a>
						<div class='space'></div>
					</div>
				";
			}

			$query_a = "SELECT COUNT(*) FROM articles WHERE category_id = ? AND author_id = ?";
			$query_d = "SELECT COUNT(*) FROM articles WHERE category_id = ? AND author_id = ?";
			
			$count_a = $link->GetRow($query_a, [4, $result['userid']]);
			$count_a = $count_a['COUNT(*)'];

			$count_d = $link->GetRow($query_d, [3, $result['userid']]);
			$count_d = $count_d['COUNT(*)'];

			$content_2 .= "
				<p>
				<a href='".$home.$lang.'/auditorium-user/'.$result['userid']."'>$c[auditorium_user]".$result['username'].' ('.$count_a.')'."</a><br>
				<a href='".$home.$lang.'/downloads-user/'.$result['userid']."'>$c[downloads_user]".$result['username'].' ('.$count_d.')'."</a>
				</p>
			";

			$pagination = Engine::Pagination($page, $num_page, $content2);

			$output = $content_1.$content_2.$pagination;
		} else {
			
			$output = "<h1>$c[no_articles]</h1>";
		}	
	} else {
		
		$output = "<h1>$c[protected]</h1>";
	}
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>