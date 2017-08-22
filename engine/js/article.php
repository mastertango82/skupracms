<?php

$js = "
	<script>
		function Like(like) {
		    if (like == '') {
		        document.getElementById(like).innerHTML = '';
		        return;
		    } else {
		        if (window.XMLHttpRequest) {
		            xmlhttp = new XMLHttpRequest();
		        } else {
		            xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		        }
		        xmlhttp.onreadystatechange = function() {
		            if (this.readyState == 4 && this.status == 200) {
		                document.getElementById(like).innerHTML = this.responseText;
		            }
		        };
		        xmlhttp.open('GET','".$home.'engine/scripts/'."like_article.php?l='+like,true);
		        xmlhttp.send();
		    }
		}
		function Dislike(dislike) {
		    if (dislike == '') {
		        document.getElementById(dislike).innerHTML = '';
		        return;
		    } else {
		        if (window.XMLHttpRequest) {
		            xmlhttp = new XMLHttpRequest();
		        } else {
		            xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		        }
		        xmlhttp.onreadystatechange = function() {
		            if (this.readyState == 4 && this.status == 200) {
		                document.getElementById(dislike).innerHTML = this.responseText;
		            }
		        };
		        xmlhttp.open('GET','".$home.'engine/scripts/'."dislike_article.php?l='+dislike,true);
		        xmlhttp.send();
		    }
		}
	</script>
";

?>