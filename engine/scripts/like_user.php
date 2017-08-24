<?php
session_start();

require_once '../../basic-config.php';

require_once '../../engine/classes/DB.class.php';
require_once '../../engine/classes/Language.class.php';

$site = BasicConfig::$_site;
$home = BasicConfig::$_home;

$frk = BasicConfig::$_prefix;
$users = $frk.'users';

$query = "UPDATE $users SET like_user = like_user + 1 WHERE userid = ?";

$link = new DB();

$userid = substr($_GET['l'], 0, -5);

if (in_array($userid, $_SESSION[$site]['likeusers'])) {
	
	$query2 = "SELECT like_user FROM $users WHERE userid = ?";
	$result2 = $link->GetRow($query2, [$userid]);
	echo "<img class='like' src='".$home.'look/img/like.png'."'> $result2[like_user]";
} else {

	$result = $link->UpdateRow($query, [$userid]);
	$_SESSION[$site]['likeusers'][] = $userid;

	$query2 = "SELECT like_user FROM $users WHERE userid = ?";
	$result2 = $link->GetRow($query2, [$userid]);
	echo "<img class='like' src='".$home.'look/img/like.png'."'> $result2[like_user]";
}

?>