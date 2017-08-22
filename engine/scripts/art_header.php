<?php

$art_header = "
	<h1><a href='".$home.$lang.'/'.$article['cat_seo_name'].'/'.$article['seo']."'>$article[$header]</a></h1>
	<p class='sub'><span class='sub-dat'>$adate</span>&nbsp;&nbsp;<img class='like' src='".$home.'look/img/author.png'."'> <a href='".$home.$lang.'/member/'.$article['userid']."'>$article[username]</a>&nbsp;&nbsp;<img class='like' src='".$home.'look/img/category.png'."'> <a href='".$home.$lang.'/category/'.$article['cat_seo_name']."'>$article[$cat]</a>
	<span class='like-dislike'><button class='button2' id='$article[seo]_like' onclick='Like(this.id)'><img class='like' src='".$home.'look/img/like.png'."'> $article[like_article]</button><button class='button2' id='$article[seo]_dislike' onclick='Dislike(this.id)'><img class='like' src='".$home.'look/img/dislike.png'."'> $article[dislike_article]</button><a href='".$home.$lang.'/'.$article['cat_seo_name'].'/'.$article['seo']."'><button class='button2'><img class='like' src='".$home.'look/img/comments.png'."'> <b>$total</b></button></a>
	</span>
";

?>