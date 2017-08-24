<?php

if ($usertype == 0) {
	
	$output = "<h1>$c[protected]</h1>";
} else {
	
	$link = new DB();
	
	$frk = BasicConfig::$_prefix;
	$users = $frk.'users';
	
	$query0 = "SELECT COUNT(*) FROM $users WHERE usertype > ?";

	$result0 = $link->GetRow($query0, [-3]);
	$total = ($result0['COUNT(*)']);

	$limit = parent::$_limit_users;

	$page = isset($_GET['page']) ? $_GET['page'] : 1;

	$start = $limit * ($page-1);

	$num_page = ceil($total/$limit);

	if (isset($_GET['content2']) AND $_GET['content2'] === 'like') {
		
		$order_notice = $c['order_like_ar'];
		$query = "SELECT * FROM $users WHERE usertype > ? ORDER BY like_user DESC LIMIT $start, $limit";
	} else if (isset($_GET['content2']) AND $_GET['content2'] === 'dislike') {
		
		$order_notice = $c['order_dislike_ar'];
		$query = "SELECT * FROM $users WHERE usertype > ? ORDER BY dislike_user DESC LIMIT $start, $limit";
	} else if (isset($_GET['content2']) AND $_GET['content2'] === 'old') {
		
		$order_notice = $c['order_old_ar'];
		$query = "SELECT * FROM $users WHERE usertype > ? ORDER BY userid ASC LIMIT $start, $limit";
	} else {
		
		$order_notice = $c['order_new_ar'];
		$query = "SELECT * FROM $users WHERE usertype > ? ORDER BY userid DESC LIMIT $start, $limit";
	}

	if ($usertype == 4) {

		$res = $link->GetRows($query, [-4]);
	} else {
		
		$res = $link->GetRows($query, [0]);
	}
		

	if (!empty($res)) {
		
		$output = "
			<div class='dropdown2' style='float:right;'>
			<button class='dropbtn2'>$c[order]</button>
			<div class='dropdown-content2'>
				<a href='".$home.$lang.'/'.$content1.'/new/'.$page."'>$c[ord_new]</a>
				<a href='".$home.$lang.'/'.$content1.'/like/'.$page."'>$c[ord_like]</a>
				<a href='".$home.$lang.'/'.$content1.'/dislike/'.$page."'>$c[ord_dislike]</a>
				<a href='".$home.$lang.'/'.$content1.'/old/'.$page."'>$c[ord_old]</a>
			</div>
		</div>
		<h2 class='head'>$c[members]</h2>
		<p class='info'>$order_notice</p>
		<div class='clear'></div>
		";

		require_once 'engine/js/user.php';
		$output .= $js;

		foreach ($res as $result) {
			
			if ($result['usertype'] == 1) {
				
				$head = "<h3>$c[member]: $result[username]</h3>";
			} else if ($result['usertype'] == 2) {
				
				$head = "<h3>$c[author]: $result[username]</h3>";
			} else if ($result['usertype'] == 3) {
				
				$head = "<h3>$c[moderator]: $result[username]</h3>";
			} else if ($result['usertype'] == 4) {
				
				$head = "<h3>$c[administrator]: $result[username]</h3>";
			} else if ($result['usertype'] == -1) {
				
				$head = "<h3>$c[noactiv]: $result[username]</h3>";
			} else if ($result['usertype'] == -2) {
				
				$head = "<h3>$c[blockuser]: $result[username]</h3>";
			} else if ($result['usertype'] == -3) {
				
				$head = "<h3>$c[deleteduser]: $result[username]</h3>";
			}

			$adate = explode('-', $result['date_reg']);
			$adate = $adate[2].'.'.$adate[1].'.'.$adate[0];

			if ($result['gender'] == 'male') {
				
				$gender = $c['man'];
			} else if ($result['gender'] == 'female') {
				
				$gender = $c['woman'];
			} else {

				$gender = '';
			}

			$output .= "
				$head
				<div class='block2'>
					<img class='avatar' src='".$home.'content/avatars/'.$result['avatar']."'>
					$c[name]: $result[name]<br>
					$c[lastname]: $result[lastname]<br>
					$c[birth]: $result[birth]<br>
					$c[gender]: $gender<br>
					$c[date_reg]: $adate<br>
					$c[signature]: $result[signature]<br>
					<span class='plus-minus'><button class='button2' id='$result[userid]_like' onclick='Like(this.id)'><img class='like' src='".$home.'look/img/like.png'."'> $result[like_user]</button><button class='button2' id='$result[userid]_dislike' onclick='Dislike(this.id)'><img class='like' src='".$home.'look/img/dislike.png'."'> $result[dislike_user]</button>
					</span>
				</div>
				<div class='block2'>
				$c[email]: $result[email]<br>
				$c[website2]: <a href='$result[website]'>$result[website]</a><br>
				<p>$c[description]: $result[description]</p>
				<a href='".$home.$lang.'/articles-from/'.$result['userid']."'>$c[num_articles] ($result[num_art])</a>
				</div>
				<div class='horline'></div>
			";
		}

		$output .= Engine::Pagination($page, $num_page, '');
	}
}

?>