<?php

if ($usertype > 2) {

	$output = "<h1>$c[add_category]</h1>";

	$e = Language::LangPart('edit');

	$error = '';
	
	if (isset($_POST['submit'])) {
		if (!empty($_POST['cat_name_sr']) AND !empty($_POST['cat_name_en']) 
			AND !empty($_POST['cat_desc_sr']) AND !empty($_POST['cat_desc_en'])) {

			$cat_name_sr = $_POST['cat_name_sr'];
			$cat_name_en = $_POST['cat_name_en'];
			$cat_desc_sr = $_POST['cat_desc_sr'];
			$cat_desc_en = $_POST['cat_desc_en'];

			$error = Engine::AddCategory($cat_name_sr, $cat_name_en, $cat_desc_sr, $cat_desc_en);
		} else {
			$error = $e['empty_fields'];
		}
	}

	$output .= "
		<p><b>$c[fields_mand]</b></p>
		<p class='red'>$error</p>
		<form action='' method='post'>
			$c[cat_name_sr]:<br>
			<input type='text' name='cat_name_sr' maxlength='32' class='field1'><br><br>
			$c[cat_name_en]:<br>
			<input type='text' name='cat_name_en' maxlength='32' class='field1'><br><br>
			$c[cat_desc_sr]:<br>
			<textarea class='textarea1' name='cat_desc_sr' maxlength='255'></textarea><br><br>
			$c[cat_desc_en]:<br>
			<textarea class='textarea1' name='cat_desc_en' maxlength='255'></textarea><br><br>
			<input type='submit' class='button1' name='submit' value='$c[confirm]'>
		</form>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>