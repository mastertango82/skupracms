<?php
session_start();

require_once '../../config.php';
require_once '../../engine/classes/DB.class.php';
require_once '../../engine/classes/Language.class.php';

$site = Config::$_site;
$home = Config::$_home;

$query = "UPDATE articles SET like_article = like_article + 1 WHERE seo = ?";

$link = new DB();

$article = substr($_GET['l'], 0, -5);

if (in_array($article, $_SESSION[$site]['likearticles'])) {
	
	$query2 = "SELECT like_article FROM articles WHERE seo = ?";
	$result2 = $link->GetRow($query2, [$article]);
	echo "<img class='like' src='".$home.'look/img/like.png'."'> $result2[like_article]";
} else {
	
	$result = $link->UpdateRow($query, [$article]);
	$_SESSION[$site]['likearticles'][] = $article;

	$query2 = "SELECT like_article FROM articles WHERE seo = ?";
	$result2 = $link->GetRow($query2, [$article]);
	echo "<img class='like' src='".$home.'look/img/like.png'."'> $result2[like_article]";
}

?>