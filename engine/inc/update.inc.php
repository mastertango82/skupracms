<?php

if ($usertype > 1) {
	
	$frk = BasicConfig::$_prefix;

	$articles = $frk.'articles';
	$users = $frk.'users';

	if (isset($_GET['page'])) {
		
		$error = '';

		$output = "
			<h1>$c[update_article]</h1>
		";
		
		if (substr($_GET['page'], -7) === '_update') {

			$article_id = substr($_GET['page'], 0, -7);
			
			if (isset($_POST['submit'])) {

            if (!empty($_POST['header_sr']) 
                AND !empty($_POST['header_en']) 
                AND !empty($_POST['seo']) 
                AND !empty($_POST['category_id']) 
                AND !empty($_POST['body_sr'])) {

	                $header_sr = $_POST['header_sr'];
	                $header_en = $_POST['header_en'];
	                $seo = $_POST['seo'];
	                $category_id = $_POST['category_id'];
	                $body_sr = $_POST['body_sr'];

	                $favorite = (isset($_POST['favorite'])) ? 1 : 0;
	                $multi_lang = (isset($_POST['multi_lang'])) ? 1 : 0;
	                $footer = (isset($_POST['footer'])) ? 1 : 0;
	                $publish = (isset($_POST['publish'])) ? 1 : 0;

	                $body_en = $_POST['body_en'];

	                $author_id = $_POST['author_id'];

	                $error = Engine::UpdateArticle($author_id, $article_id, $header_sr, $header_en, $seo, $category_id, $body_sr, $body_en, $multi_lang, $favorite, $footer, $publish);
	            } else {
	                $error = $e['empty_fields'];
	            }
       		}

			$link = new DB();

			if ($usertype == 4) {
				$query = "SELECT * FROM $articles JOIN $users ON $articles.author_id = $users.userid AND $articles.article_id = ?";
				$result = $link->GetRow($query, [$article_id]);
			} else {
				$query = "SELECT * FROM $articles JOIN $users ON $articles.author_id = $users.userid AND $articles.article_id = ? AND $users.username = ?";
				$result = $link->GetRow($query, [$article_id, $_SESSION[$site]['username']]);
			}
			$_SESSION[$site]['var']['cat_id'] = $result['category_id'];
			$_SESSION[$site]['var']['article_publish'] = $result['publish'];
			
			if (!empty($result)) {

				$selectbox = Engine::SelectBox($result['category_id']);

				$body_sr = htmlentities($result['body_sr']);
				$body_en = htmlentities($result['body_en']);

				if ($result['multi_lang'] == 1) {
					$checked_mul = 'checked';
				} else {
					$checked_mul = '';
				}

				if ($result['favorite'] == 1) {
					$checked_fav = 'checked';
				} else {
					$checked_fav = '';
				}

				if ($result['footer'] == 1) {
					$checked_foo = 'checked';
				} else {
					$checked_foo = '';
				}

				if ($result['publish'] == 1) {
					$checked_pub = 'checked';
				} else {
					$checked_pub = '';
				}

					$output .= "

				        <p class='red'>$error</p>
						<form action='' method='post'>
				        $c[header_sr](*):<br>
				        <input type='text' name='header_sr' class='field2' maxlength='128' value='$result[header_sr]'><br><br>
				        $c[header_en](*):<br>
				        <input type='text' name='header_en' class='field2' maxlength='128' value='$result[header_en]'><br><br>
				        $c[seo_header](*):<br>
				        <input type='text' name='seo' class='field2' maxlength='128' value='$result[seo]'><br><br>
				        $c[category](*): 
				        <select class='selbox1' name='category_id'>
				        $selectbox
				        </select><br><br>
				        $c[body_sr](*)<br>
				        <textarea id='edit' name='body_sr'>$body_sr
				        </textarea><br><br>
				        $c[multi_lang]: <input type='checkbox' $checked_mul name='multi_lang'><br><br>
				        $c[body_en]<br>
				        <textarea id='edit' name='body_en'>$body_en
				        </textarea><br><br>
				        $c[favorite]: <input type='checkbox' $checked_fav name='favorite'><br>
				        $c[footer]: <input type='checkbox' $checked_foo name='footer'><br>
				        $c[publish]: <input type='checkbox' $checked_pub name='publish'><br><br>
				        <input type='hidden' name='author_id' value='$result[author_id]'>
				        <input type='submit' name='submit' class='button1' value='$c[confirm]'>
						</form>
						<script src='".$home."engine/tinymce/tinymce.min.js'></script>
				  		<script>tinymce.init({
				        relative_urls : false,
				        remove_script_host : true,
				        document_base_url : '".$home."',
				        content_css : '".$home.'look/css/style.css'."',
				  selector: 'textarea',
				  height: 400,
				  theme: 'modern',
				  plugins: [
				    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
				    'searchreplace wordcount visualblocks visualchars code fullscreen',
				    'insertdatetime media nonbreaking save table contextmenu directionality',
				    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
				  ],
				  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
				  image_advtab: true,
				  templates: [
				    { title: 'Test template 1', content: 'Test 1' },
				    { title: 'Test template 2', content: 'Test 2' }
				  ]
				 });</script>
					";
			}
		}
	} else {		

		$link = new DB();

		if ($usertype == 4) {
			$query0 = "SELECT COUNT(*) FROM $articles JOIN $users ON $articles.author_id = $users.userid";
			$result0 = $link->GetRow($query0);
		} else {

			$query0 = "SELECT COUNT(*) FROM $articles JOIN $users ON $articles.author_id = $users.userid AND $users.username = ?";
			$result0 = $link->GetRow($query0, [$_SESSION[$site]['username']]);	
		}

		$total = ($result0['COUNT(*)']);
		$limit = 30;
		$page = isset($_GET['content2']) ? $_GET['content2'] : 1;
		$start = $limit * ($page-1);
		$num_page = ceil($total/$limit);
		
		if ($usertype == 4) {
			$query = "SELECT * FROM $articles JOIN $users ON $articles.author_id = $users.userid ORDER BY article_id DESC LIMIT $start, $limit";
			$result = $link->GetRows($query);
		} else {
			$query = "SELECT * FROM $articles JOIN $users ON $articles.author_id = $users.userid AND $users.username = ? ORDER BY article_id DESC LIMIT $start, $limit";
			$result = $link->GetRows($query, [$_SESSION[$site]['username']]);
		}

		if (!empty($result)) {
			
			$output = "
				<h1>$c[update_article]</h1>
			";

			foreach ($result as $article) {

				$output .= "<p><a href='".$home.$lang.'/update/article/'.$article['article_id'].'_update'."'><b>$article[username] | $article[article_id] | $article[odate_ar]</b></a> | $article[seo] | $article[header_sr] | $article[header_en]</p>";
			}

			$output .= Engine::Pagination($page, $num_page, '');
		} else {

			$output = "<h1>$c[no_content]</h1>";
		}
	}
} else {

	$output = "<h1>$c[protected]</h1>";
}

?>