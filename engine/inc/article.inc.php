<?php

$link = new DB();

$query = "SELECT * FROM articles JOIN users ON articles.author_id = users.userid AND articles.seo = ? AND publish = ? JOIN categories ON articles.category_id = categories.cat_id";
$article = $link->GetRow($query, [$content2, 1]);

if (!empty($article)) {
	
	if (isset($_POST['submit'])) {

		$comm = htmlspecialchars($_POST['comm'], ENT_QUOTES);

		$datetimes = date("Y-m-d H:i:s");
		$artic = $article['article_id'];
		$user = $_SESSION[$site]['userid'];

		if (!empty($comm)) {
			
			if ($usertype == 0) {
				if ($_SESSION[$site]['var']['result2'] == $_POST['result2']) {
					
					$add_comm = Engine::AddComment($datetimes, $comm, $artic, $_SESSION[$site]['userip']);
					header("Location: ".$home.$lang.'/'.$_GET['content1'].'/'.$_GET['content2']);
				}	
			} else {
				
				$add_comm = Engine::AddComment($datetimes, $comm, $artic, $_SESSION[$site]['userip']);
				header("Location: ".$home.$lang.'/'.$_GET['content1'].'/'.$_GET['content2']);
			}
		}
	}

	$query2 = "SELECT * FROM comments JOIN users ON comments.user = users.userid AND comments.artic_id = ?";
	$query22 = "SELECT * FROM comments WHERE user = ? AND artic_id = ?";
	$comments2 = $link->GetRows($query2, [$article['article_id']]);
	$comments22 = $link->GetRows($query22, [0, $article['article_id']]);

	$comments = array_merge($comments2, $comments22);
	
	$allcomm = '';
	
	foreach ($comments as $comm) {

		$viewdateq = explode (' ', $comm['datetimes']);

		$viewdate = $viewdateq[0];
		$time = $viewdateq[1];

		$viewdate = explode ('-',$viewdate);
		$viewdate = $viewdate[2].'.'.$viewdate[1].'.'.$viewdate[0];

		$time = explode(':', $time);
		$time = $time[0].':'.$time[1];

		$viewdateall = $viewdate.' - '.$time;

		if ($comm['user'] > 0) {

			$allcomm .= "<p>$comm[username] | $viewdateall | <b>$comm[comment]</b></p>";
		} else {
			
			$allcomm .= "<p>$c[guest] | $viewdateall | <b>$comm[comment]</b></p>";
		}
	}

	if ($usertype > 0) {
		
		$allcomcom = 
		"
			<div class='horline'></div>
			<p>$c[comm]</p>
			<form action='' method='post'>
			<textarea class='textarea2' name='comm' maxlength='150'></textarea><br>
			<input type='submit' class='button1' name='submit' value='$c[confirm]'>
			</form>
			$allcomm
		";
	} else {
		
		$o1 = rand (0, 5);
		$o2 = rand (0, 5);
	
		$_SESSION[$site]['var']['result2'] = $o1 + $o2;
		
		$allcomcom = 
		"
			<div class='horline'></div>
			<p>$c[comm]</p>
			<form action='' method='post'>
			<textarea class='textarea2' name='comm' maxlength='150'></textarea><br>
			$o1 + $o2 = <input type='text' name='result2' class='field3'>
			<input type='submit' class='button1' name='submit' value='$c[confirm]'>
			</form>
			$allcomm
		";	
	}

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
	
	require_once 'engine/js/article.php';
	$output = $js;

	require 'engine/scripts/art_header.php';
	
	$output .= "
		<div class='block'>
			$art_header
			</p>
			$article[$body]
			$allcomcom
		</div>
	";
	
	$articleid = $article['article_id'];
	$cate = $article['cat_seo_name'];

	$query = "SELECT * FROM articles JOIN categories ON articles.category_id = categories.cat_id AND articles.article_id < ? AND categories.cat_seo_name = ? AND publish = ? ORDER BY articles.article_id DESC LIMIT 1";
	$query2 = "SELECT * FROM articles JOIN categories ON articles.category_id = categories.cat_id AND articles.article_id > ? AND categories.cat_seo_name = ? AND publish = ? ORDER BY articles.article_id ASC LIMIT 1";

	$l1 = $link->GetRow($query, [$articleid, $cate, 1]);
	$l2 = $link->GetRow($query2, [$articleid, $cate, 1]);

	if ($l1[$header] == '') {
		$levo = '';
	} else {
		$levo = "&lt;&lt;&lt; $l1[$header]";
	}

	if ($l2[$header] == '') {
		$desno = '';
	} else {
		$desno = "$l2[$header] &gt;&gt;&gt;";
	}

	$output .= "<p id='pagi'>$c[same_cat]<a href='".$home.$lang.'/'.$l1['cat_seo_name'].'/'.$l1['seo']."'>$levo</a> | <a href='".$home.$lang.'/'.$l2['cat_seo_name'].'/'.$l2['seo']."'>$desno</a></p>";	
} else {
	
	$output = "<h1>$c[no_content]</h1>";
}

?>