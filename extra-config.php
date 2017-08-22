<?php

class ExtraConfig {

	static protected $_default_content		= 'all-articles';

	static protected $_min_members			= 0; // lažni članovi minimalni random
	static protected $_max_members			= 2; // lažni članovi maksimalni random
	static protected $_min_guests			= 2; // lažni gosti minimalni random
	static protected $_max_guests			= 5; // lažni gosti maksimalni random

	static protected $_online_pause 		= 600; // sekundi, vreme koje se računa za online (5 minuta)
	static protected $_limit_articles 		= 10; // prikazivanje članaka po strani za opciju sve
	static protected $_limit_articles_from 	= 10; // prikazivanje članaka od jednog korisnika
	static protected $_limit_articles_arc	= 10; // prikazivanje celog teksta za arhivu
	static protected $_limit_users 			= 20; // prikazivanje korisnika po starni
	static protected $_limit_ip_visitors 	= 50; // broj ip adresa po strani za posetioce, koji se prate
	static protected $_old_mess_leave 		= 10; // broj poruka koje ostaju nakon brisanja poruka dana
	static protected $_limit_linemessages	= 30; // broj linijskih poruka za prikazivanje
	static protected $_limit_comments		= 20; // prikazivanje komentara za brisanje

	static protected function MetaBase() {

		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		if ($_SESSION[$site]['userlang'] === 'en') {

			$c = array(

				'html_lang'		=> 'en',
				'charset'		=> 'utf-8',
				'description'	=> 'Free-Internet organization that exists in order to enrich society and introduce new forms of communication in the internet.',
				'keywords'		=> 'Web, organization, society, intenet, blog, articles, services, construction, sites, agencies',
				'author'		=> 'Milos Toplicic',
				'favicon'		=> $home.'favicon.png',
				'font'			=> $home.'look/css/font.php',
				'awesome'		=> $home.'look/fonts/font-awesome-4.7.0/css/font-awesome.min.css',
				'style'			=> $home.'look/css/site.css',
				'maintitle'		=> 'DNewBlog',
				'motto'			=> 'a place we need...'
			);
		} else {

			$c = array(

				'html_lang'		=> 'sr',
				'charset'		=> 'utf-8',
				'description'	=> 'Слободоумна Интернет Организација која постоји са циљем да оплемени друштво и уведе нове форме у интернет комуникацији.',
				'keywords'		=> 'web, организација, друштво, интенет, блог, текстови, услуге, израда, сајтови, агенција',
				'author'		=> 'Милош Топличић',
				'favicon'		=> $home.'favicon.png',
				'font'			=> $home.'look/css/font.php',
				'awesome'		=> $home.'look/fonts/font-awesome-4.7.0/css/font-awesome.min.css',
				'style'			=> $home.'look/css/site.css',
				'maintitle'		=> 'ДНовиБлог',
				'motto'			=> 'место које нам треба...'
			);
		}

		return $c;
	}
}

?>
