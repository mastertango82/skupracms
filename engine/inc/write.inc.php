<?php

if ($usertype > 1) {
	
    $e = Language::LangPart('edit');

	$selectbox = Engine::SelectBox('');

    $error = '';

        $_SESSION[$site]['var']['header_sr'] = '';
        $_SESSION[$site]['var']['header_en'] = '';
        $_SESSION[$site]['var']['seo'] = '';


        if (isset($_POST['submit'])) {

            $_SESSION[$site]['var']['header_sr'] = $header_sr = $_POST['header_sr'];
            $_SESSION[$site]['var']['header_en'] = $header_en = $_POST['header_en'];
            $_SESSION[$site]['var']['seo'] = $seo = $_POST['seo'];
            $category_id = $_POST['category_id'];
            
            $favorite = (isset($_POST['favorite'])) ? 1 : 0;
            $multi_lang = (isset($_POST['multi_lang'])) ? 1 : 0;
            $footer = (isset($_POST['footer'])) ? 1 : 0;
            $publish = (isset($_POST['publish'])) ? 1 : 0;

            $_SESSION[$site]['var']['body_sr'] = $body_sr = $_POST['body_sr'];
            $_SESSION[$site]['var']['body_en'] = $body_en = $_POST['body_en'];
            
            if (!empty($_POST['header_sr']) 
                AND !empty($_POST['header_en']) 
                AND !empty($_POST['seo']) 
                AND !empty($_POST['category_id']) 
                AND !empty($_POST['body_sr'])) {

                $error = Engine::WriteArticle($header_sr, $header_en, $seo, $category_id, $body_sr, $body_en, $multi_lang, $favorite, $footer, $publish);
            } else {
                $error = $e['empty_fields'];
            }
        }

        $body_sr_ses = isset($_SESSION[$site]['var']['body_sr']) ? htmlentities($_SESSION[$site]['var']['body_sr']) : '';
        $body_en_ses = isset($_SESSION[$site]['var']['body_en']) ? htmlentities($_SESSION[$site]['var']['body_en']) : '';
	$output = "
		<h1>$c[write_article]</h1>
        <p class='red'>$error</p>
		<form action='' method='post'>
        $c[header_sr](*):<br>
        <input type='text' name='header_sr' class='field2' maxlength='128' value='".$_SESSION[$site]['var']['header_sr']."'><br><br>
        $c[header_en](*):<br>
        <input type='text' name='header_en' class='field2' maxlength='128' value='".$_SESSION[$site]['var']['header_en']."'><br><br>
        $c[seo_header](*):<br>
        <input type='text' name='seo' class='field2' maxlength='128' value='".$_SESSION[$site]['var']['seo']."'><br><br>
        $c[category](*): 
        <select class='selbox1' name='category_id'>
        $selectbox
        </select><br><br>
        $c[body_sr](*)<br>
        <textarea id='edit' name='body_sr'>".$body_sr_ses."
        </textarea><br><br>
        $c[multi_lang]: <input type='checkbox' name='multi_lang'><br><br>
        $c[body_en]<br>
        <textarea id='edit' name='body_en'>".$body_en_ses."
        </textarea><br><br>
        $c[favorite]: <input type='checkbox' name='favorite'><br>
        $c[footer]: <input type='checkbox' name='footer'><br>
        $c[publish]: <input type='checkbox' checked name='publish'><br><br>
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
                 });
                 </script>
        ";

} else {
	
    $output = "<h1>$c[protected]</h1>";
}

?>