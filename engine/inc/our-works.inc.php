<?php

if ($userlang == 'en') {
	
	$klient1 = 'Zoran Krstic - portal for news';
	$klient1a = 'Zoran Krstic - Download site';
	$rad1 = "PDO:: database (OOP) <br> Safe use of the database using the PDO model and object programming, also has a user manual.";
} else {
	
	$klient1 = 'Зоран Крстић - портал за вести';
	$klient1a = 'Зоран Крстић, преузимање сајта';
	$rad1 = "PDO:: baza (OOP) <br> Сигурно коришћење базе помоћу модела ПДО и објектног програмирања, има и упутство за употребу.";
}

$output = "
	<div class='block'>
		<h1>$c[ourworks]</h1>
		<p><b>1. </b><a href='".$home.'krstic'."' target='_blank'>$klient1</a></p>
		<p><b>1. a) </b><a href='".$home.'content/razno/krstic.tar.gz'."' target='_blank'>$klient1a</a></p>
		<p><b>2. </b><a href='".$home.'content/razno/PDO_database.tar.gz'."' target='_blank'>$rad1</a></p>
	</div>
";

?>