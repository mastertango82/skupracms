<?php

if ($usertype > 2) {
	
	$e = Language::LangPart('edit');
	
	$output = "<h1>$c[update_category]</h1>";

	if (isset($_GET['content2'])) {

		$link = new DB();
		$query1 = "SELECT * FROM categories WHERE cat_id = ?";
		$result1 = $link->GetRow($query1, [$_GET['content2']]);

		$cat = $result1;

		$error = '';
	
		if (isset($_POST['submit'])) {
			if (!empty($_POST['cat_name_sr']) AND !empty($_POST['cat_name_en']) 
				AND !empty($_POST['cat_desc_sr']) AND !empty($_POST['cat_desc_en'])) {

				$cat_name_sr = $_POST['cat_name_sr'];
				$cat_name_en = $_POST['cat_name_en'];
				$cat_desc_sr = $_POST['cat_desc_sr'];
				$cat_desc_en = $_POST['cat_desc_en'];
				$cat_name_sr_old = $cat['cat_name_sr'];

				$error = Engine::UpdateCategory($cat_name_sr_old, $cat_name_sr, $cat_name_en, $cat_desc_sr, $cat_desc_en);
			} else {
				$error = $e['empty_fields'];
			}
		}

		$output .= "
			<p><b>$c[fields_mand]</b></p>
			<p class='red'>$error</p>
			<form action='' method='post'>
				$c[cat_name_sr]:<br>
				<input type='text' name='cat_name_sr' maxlength='32' class='field1' value='$cat[cat_name_sr]'><br><br>
				$c[cat_name_en]:<br>
				<input type='text' name='cat_name_en' maxlength='32' class='field1' value='$cat[cat_name_en]'><br><br>
				$c[cat_desc_sr]:<br>
				<textarea class='textarea1' name='cat_desc_sr' maxlength='255'>$cat[cat_description_sr]</textarea><br><br>
				$c[cat_desc_en]:<br>
				<textarea class='textarea1' name='cat_desc_en' maxlength='255'>$cat[cat_description_en]</textarea><br><br>
				<input type='submit' class='button1' name='submit' value='$c[confirm]'>
			</form>
		";
	} else {

		$link = new DB();
		$query = "SELECT * FROM categories";
		$result = $link->GetRows($query);

		if (!empty($result)) {

			foreach ($result as $cat) {

				$output .= "
					<p><a href='".$home.$lang.'/update-category/'.$cat['cat_id']."'>$cat[cat_id] | $cat[cat_name_sr] | $cat[cat_name_en]</a></p>
				";
			}
		}
	}
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>