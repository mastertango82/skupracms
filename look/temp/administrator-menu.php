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
				<a href='".$home.$lang.'/'.'delete'."'>$c[delete]</a>
				<a href='".$home.$lang.'/'.'notpublished'."'>$c[notpublished]</a>
			</div>
		</li>
		<li><a href='".$home.$lang.'/'.'favorites'."' title='$c[favorites]'><i class='fa fa-star-o fa-lg' title='$c[favorites]'></i></a></li>
		<li class='dropdown'>
			<a href='#' title='$c[categories]' class='dropbtn'><i class='fa fa-list fa-lg' title='$c[categories]'></i></a>
			<div class='dropdown-content'>
				<a href='".$home.$lang.'/'.'categories'."'>$c[see_categories]</a>
				<a href='".$home.$lang.'/'.'add-category'."'>$c[add_category]</a>
				<a href='".$home.$lang.'/'.'update-category'."'>$c[update_category]</a>
				<a href='".$home.$lang.'/'.'delete-category'."'>$c[delete_category]</a>
			</div>
		</li>
		<li><a href='".$home.$lang.'/'.'archives'."' title='$c[archives]'><i class='fa fa-calendar fa-lg' title='$c[archives]'></i></a></li>
		<li class='dropdown'>
			<a href='#' title='$c[statuses]' class='dropbtn'><i class='fa fa-comments fa-lg' title='$c[statuses]'></i></a>
			<div class='dropdown-content'>
				<a href='".$home.$lang.'/'.'statuses'."'>$c[see_statuses]</a>
				<a href='".$home.$lang.'/'.'delete-statuses'."'>$c[delete_statuses]</a>
			</div>
		</li>
		<li class='dropdown'>
			<a href='#' title='$c[members]' class='dropbtn'><i class='fa fa-users fa-lg' title='$c[members]'></i></a>
			<div class='dropdown-content'>
				<a href='".$home.$lang.'/'.'members'."'>$c[see_members]</a>
				<a href='".$home.$lang.'/'.'change-usertype'."'>$c[change_usertype]</a>
			</div>
		</li>
		<li class='dropdown'>
			<a href='#' title='$c[message_day]' class='dropbtn'><i class='fa fa-paw fa-lg' title='$c[message_day]'></i></a>
			<div class='dropdown-content'>
				<a href='".$home.$lang.'/'.'all-messages'."'>$c[all_messages]</a>
				<a href='".$home.$lang.'/'.'new-message'."'>$c[new_message]</a>
				<a href='".$home.$lang.'/'.'delete-messages'."'>$c[delete_messages]</a>
			</div>
		</li>
		<li class='dropdown'>
			<a href='#' title='$c[plus]' class='dropbtn'><i class='fa fa-diamond fa-lg' title='$c[plus]'></i></a>
			<div class='dropdown-content'>
				<a href='".$home.$lang.'/'.'block-member'."'>$c[block_member]</a>
				<a href='".$home.$lang.'/'.'block-ip'."'>$c[block_ip]</a>
				<a href='".$home.$lang.'/'.'delete-comment'."'>$c[delete_comment]</a>
				<a href='".$home.$lang.'/'.'delete-member'."'>$c[delete_member]</a>
			</div>
		</li>
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