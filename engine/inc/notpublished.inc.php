<?php

if ($usertype == 4) {
	
	if (isset($_POST['submit1'])) {

		$link = new DB();
		$query = "DELETE FROM articles WHERE article_id = ?";
		$result = $link->DeleteRow($query, [$_POST['ariddelete']]);

		if ($result == 1) {

			header("Location: $home$lang".'/delete-success');
		}
	}

	if (isset($_POST['submit2'])) {

		$link = new DB();
		$userid = Engine::UserId($_POST['author']);

		$query = "UPDATE articles SET author_id = ? WHERE article_id = ?";
		$result = $link->UpdateRow($query, [$userid, $_POST['arid']]);

		if ($result == 1) {

			header("Location: $home$lang".'/update-art-success');
		}
	}

	$link = new DB();
	$query = "SELECT * FROM articles JOIN categories ON articles.category_id = categories.cat_id AND publish = ?";
	$result = $link->GetRows($query, [0]);

	if (!empty($result)) {
		
		$output = "
			<h1>$c[notpublished]</h1>
		";

		foreach ($result as $article) {

			$output .= "<p>$article[article_id] | $article[header_sr] | $article[header_en]</p>";
		}

		$output .= "
			<form action='' method='post'>
			$c[delete_number] 
			<input type='text' class='field3' name='ariddelete'>
			<input type='submit' name='submit1' class='button1' value='$c[confirm]'><br><br>
			<hr>
			<h2>$c[new_author]</h2>
			$c[change_author]:<br>
			<input type='text' class='field3' name='arid'><br>
			$c[new_author]:<br>
			<input type='text' class='field1' name='author'><br>
			<input type='submit' name='submit2' class='button1' value='$c[confirm]'>
			</form>
		";
	} else {

		$output = "<h1>$c[no_content]</h1>";
	}	
} else {

	$output = "<h1>$c[protected]</h1>";
}

?>