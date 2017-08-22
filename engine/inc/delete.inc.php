<?php

if ($usertype == 4) {

	if (isset($_POST['submit'])) {
		
		$article_id = $_POST['id'];
		
		$link = new DB();

		$query0 = "SELECT publish, author_id, category_id FROM articles WHERE article_id = ?";
		$result0 = $link->GetRow($query0, [$article_id]);
		$cat_id = $result0['category_id'];
		$author_id = $result0['author_id'];
		$publish = $result0['publish'];

		$query = "DELETE FROM articles WHERE article_id = ?";
		$result = $link->DeleteRow($query, [$article_id]);

		if ($result == 1) {
			
			if ($publish == 1) {
				
				$query2 = "UPDATE categories SET num_art = num_art - 1 WHERE cat_id = ?";
				$result2 = $link->UpdateRow($query2, [$cat_id]);

				if ($result2 == 1) {
					
					$query3 = "UPDATE users SET num_art = num_art - 1 WHERE userid = ?";
					$result3 = $link->UpdateRow($query3, [$author_id]);

					if ($result3 == 1) {
						
						header("Location: $home$lang".'/delete-success');
					}
				}
			} else {

				header("Location: $home$lang".'/delete-success');
			}
		}	
	}

	$link = new DB();

	$query0 = "SELECT COUNT(*) FROM articles";

	$result0 = $link->GetRow($query0);
	$total = ($result0['COUNT(*)']);

	$limit = 10;

	$page = isset($_GET['content2']) ? $_GET['content2'] : 1;

	$start = $limit * ($page-1);

	$num_page = ceil($total/$limit);

	$query = "SELECT * FROM articles JOIN users ON articles.author_id = users.userid ORDER BY article_id DESC LIMIT $start, $limit";
	$result = $link->GetRows($query);

	$output = "
		<h1>$c[delete_article]</h1>
		<p class='red'>$c[del_ar_not]</p>
	";

	if (!empty($result)) {

		foreach ($result as $article) {
			$output .= "
				<p><b>$article[article_id] | $article[username] | $article[odate_ar]</b> | $article[seo] | $article[header_sr] | $article[header_en]</p>
			";
		}

		$output .= "
			<form action='' method='post'>
				$c[delete_number]<br>
				<input type='text' name='id' maxlength='10' class='field3'>
				<input type='submit' name='submit' value='$c[confirm]' class='button1'>
			</form>
		";
		
		$output .= Engine::Pagination($page, $num_page, '');
	} else {
		
		$output = "<h1>$c[no_content]</h1>";
	}
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>