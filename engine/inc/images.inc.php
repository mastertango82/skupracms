<?php
if ($usertype > 1) {
	
	$e = Language::LangPart('edit');
	$error = '';
	
	$output = "
		<h1>$c[images]</h1>
	";

	if (isset($_POST['submit'])) {

		if ($_FILES['photo']['name']) {

			if ($_FILES['photo']['size'] > (1024000)) {

				$error = $e['to_large'];
			} else {
			
				$imageFileType = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {

					$error = $e['error_image'];
				} else {
					
					$rand = rand(0, 1000);

					$target = 'content/img/' . $rand . basename($_FILES['photo']['name']);
					move_uploaded_file($_FILES['photo']['tmp_name'], $target);

					$output .= $e['image_success']. $home.'content/img/'. $rand . basename($_FILES['photo']['name']);	
				}
			}
		}
	}

	$output .= "
		<p class='red'>$error</p>
		<p>$c[images_notice]</p>
		<form action='' method='post' enctype='multipart/form-data'>
			$c[your_photo]: &nbsp; <input type='file' name='photo' size='25'>
			<input type='submit' name='submit' class='button1' value='$c[confirm]'>
		</form>
	";
} else {
	
	$output .= "<h1>$c[protected]</h1>";
}

?>