<?php

if ($usertype > 0) {
	
	$result = Engine::Profile($_SESSION[$site]['userid']);

	if ($result['usertype'] == 1) {
		
		$head = "<h3>$c[member]: $result[username]</h3>";
	} else if ($result['usertype'] == 2) {
		
		$head = "<h3>$c[author]: $result[username]</h3>";
	} else if ($result['usertype'] == 3) {
		
		$head = "<h3>$c[moderator]: $result[username]</h3>";
	}  else if ($result['usertype'] == 4) {
		
		$head = "<h3>$c[administrator]: $result[username]</h3>";
	}

	if ($result['gender'] == 'male') {
		
		$gender = $c['man'];
	} else if ($result['gender'] == 'female'){
		
		$gender = $c['woman'];
	} else {

		$gender = '';
	}
	
	$adate = explode('-', $result['date_reg']);
	$adate = $adate[2].'.'.$adate[1].'.'.$adate[0];
	
	$output = "
		<h1>$c[my_profile]</h1>
		$head
		<div class='block2'>
			<img class='avatar' src='".$home.'content/avatars/'.$result['avatar']."'>
			$c[name]: $result[name]<br>
			$c[lastname]: $result[lastname]<br>
			$c[birth]: $result[birth]<br>
			$c[gender]: $gender<br>
			$c[date_reg]: $adate<br>
			$c[signature]: $result[signature]<br>
			<button class='button2'><img class='like' src='".$home.'look/img/like.png'."'> $result[like_user]</button><button class='button2'><img class='like' src='".$home.'look/img/dislike.png'."'> $result[dislike_user]</button>
			
		</div>
		<div class='block2'>
		$c[email]: $result[email]<br>
		$c[website2]: <a href='$result[website]'>$result[website]</a><br>
		<p>$c[description]: $result[description]</p>
		<a href='$home$lang".'/articles-from/'.$result['userid']."'>$c[num_articles] ($result[num_art])</a>
		</div>
	";
} else {
	
	$output = "<h1>$c[protected]</h1>";
}

?>