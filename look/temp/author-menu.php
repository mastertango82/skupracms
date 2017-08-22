<?php

$menu = "
	<form action='' method='post'>
	<ul>
		<li id='site'><a href='".$home."' title='$c[home]'><img id='logo' src='".$home."look/img/logo.png'>$c[title]</a></li>
		<li class='dropdown'>
			<a href='#' title='$c[articles]' class='dropbtn'><i class='fa fa-pencil fa-lg' title='$c[articles]'></i></a>
			<div class='dropdown-content'>
				<a href='".$home.$lang.'/'.'images'."'>$c[pictures]</a>
				<a href='".$home.$lang.'/'.'write'."'>$c[write]</a>
				<a href='".$home.$lang.'/'.'update'."'>$c[update]</a>
			</div>
		</li>
		<li><a href='".$home.$lang.'/'.'favorites'."' title='$c[favorites]'><i class='fa fa-star-o fa-lg' title='$c[favorites]'></i></a></li>
		<li><a href='".$home.$lang.'/'.'categories'."' title='$c[categories]'><i class='fa fa-list fa-lg' title='$c[categories]'></i></a></li>
		<li><a href='".$home.$lang.'/'.'archives'."' title='$c[archives]'><i class='fa fa-calendar fa-lg' title='$c[archives]'></i></a></li>
		<li><a href='".$home.$lang.'/'.'statuses'."' title='$c[statuses]'><i class='fa fa-comments fa-lg' title='$c[statuses]'></i></a></li>
		<li><a href='".$home.$lang.'/'.'members'."' title='$c[members]'><i class='fa fa-users fa-lg' title='$c[members]'></i></a></li>
		<li><a href='".$home.$lang.'/'.'studio-skupra'."' title='$c[studio]'><i class='fa fa-cube fa-lg' title='$c[studio]'></i></a></li>
		<li><a href='".$home.$lang.'/'.'downloads'."' title='$c[downloads]'><i class='fa fa-download fa-lg' title='$c[downloads]'></i></a></li>
		<li><a href='".$home.$lang.'/'.'auditorium'."' title='$c[auditorium]'><i class='fa fa-music fa-lg' title='$c[auditorium]'></i></a></li>
		<li class='dropdown'>
			<a href='#' title='$c[profile]' class='dropbtn'><i class='fa fa-user fa-lg' title='$c[profile]'></i></a>
			<div class='dropdown-content'>
				<a href='".$home.$lang.'/'.'my-profile'."'>$c[my_profile]</a>
				<a href='".$home.$lang.'/'.'edit-profile'."'>$c[edit_profile]</a>
				<a href='".$home.$lang.'/'.'private-messages'."'>$c[private_messages]</a>
				<a href='".$home.$lang.'/'.'logout'."'>$c[logout]</a>
			</div>
		</li>
		<li class='dropdown'>
			<a href='#' title='$c[language]' class='dropbtn'><i class='fa fa-language fa-lg' title='$c[language]'></i></a>
			<div class='dropdown-content'>
				<a href='".$home.'sr-ci'.$content1.$content2.$page.$op1.$op2."' id='$sc'>$c[serbian_cy]</a>
				<a href='".$home.'sr-la'.$content1.$content2.$page.$op1.$op2."' id='$sl'>$c[serbian_la]</a>
				<a href='".$home.'en'.$content1.$content2.$page.$op1.$op2."' id='$en'>$c[english]</a>
				<input id='$x' class='lang' type='submit' name='font1' value='$c[font1]'>
				<input id='$xx' class='lang' type='submit' name='font2' value='$c[font2]'>
				<input id='$xxl' class='lang' type='submit' name='font3' value='$c[font3]'>
			</div>
		</li>
		<li><a href='".$home.$lang.'/'.'our-works'."' title='$c[ourworks]'><i class='fa fa-briefcase fa-lg' title='$c[ourworks]'></i> $c[ourworks]</a></li>
	</ul>
	</form>
";

?>