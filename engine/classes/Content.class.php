<?php

class Content extends ExtraConfig {
	
	public function __construct() {

		require_once 'look/temp/index.php';
	}

	static public function Body() {

		$home = BasicConfig::$_home;
		
		$default_content = parent::$_default_content;
		$content1 = (isset($_GET['content1'])) ? $_GET['content1'] : $default_content;

		$menu = self::Menu();
		$line = self::Line();
		$banner = self::Banner();
		$main = self::Main();
		$right = self::Right();
		$left = self::Left();
		$footer = self::Footer();

		require_once 'look/temp/site.php';
		
		return $body;
	}

	static private function Menu() {

		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$default_content = parent::$_default_content;

	    $content1 = (isset($_GET['content1'])) ? '/'.$_GET['content1'] : '/'.$default_content;
	    $content2 = (isset($_GET['content2'])) ? '/'.$_GET['content2'] : '';
	    $page = (isset($_GET['page'])) ? '/'.$_GET['page'] : '';
	    $op1 = (isset($_GET['op1'])) ? '/'.$_GET['op1'] : '';
	    $op2 = (isset($_GET['op2'])) ? '/'.$_GET['op2'] : '';

		$c = Language::LangPart('menu');

		if ($_SESSION[$site]['userlang'] == 'sr-ci') {
			$sc = 'red';
			$sl = '';
			$en = '';
		} else if ($_SESSION[$site]['userlang'] == 'sr-la') {
			$sc = '';
			$sl = 'red';
			$en = '';
		} else {
			$sc = '';
			$sl = '';
			$en = 'red';
		}
		if ($_SESSION[$site]['var']['font'] == 17) {
			$x = 'red';
			$xx = '';
			$xxl = '';
		} else if ($_SESSION[$site]['var']['font'] == 18) {
			$x = '';
			$xx = 'red';
			$xxl = '';
		} else {
			$x = '';
			$xx = '';
			$xxl = 'red';
		}

		$usertype = $_SESSION[$site]['usertype'];
		$lang = $_SESSION[$site]['userlang'];

		if ($usertype == 0) {
			
			require_once 'look/temp/guest-menu.php';
		} else if ($usertype == 1) {
			
			require_once 'look/temp/member-menu.php';
		} else if ($usertype == 2) {
			
			require_once 'look/temp/author-menu.php';
		} else if ($usertype == 3) {
			
			require_once 'look/temp/moderator-menu.php';
		} else if ($usertype == 4) {
			
			require_once 'look/temp/administrator-menu.php';
		}

		return $menu;
	}

	static private function Line() {

		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$lang = $_SESSION[$site]['userlang'];
		$usertype = $_SESSION[$site]['usertype'];
		$user = $_SESSION[$site]['username'];
		$c = Language::LangPart('line');

		if ($lang === 'sr-ci' OR $lang === 'sr-la') {
			
			date_default_timezone_set("Europe/Belgrade");
			setlocale(LC_ALL, 'sr_RS.UTF-8', 'sr_CS.UTF-8');
			$message = 'message_sr';
		} else {
			
			date_default_timezone_set("Europe/Belgrade");
			setlocale(LC_ALL, 'en_EN');
			$message = 'message_en';
		}
		
		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$linemessages = $frk.'linemessages';

		$query = "SELECT * FROM $linemessages WHERE show_mess = 1";
		$result = $link->GetRow($query);

		$count = Session::Online();

		$date = strftime("%A, %d. %B");
		$date = mb_convert_case($date, MB_CASE_TITLE, "UTF-8");

		if ($usertype == 0) {
			
			return "<p><b>$date</b> | $c[message_of_day]: <b>$result[$message]</b> | <a href=".$home.$lang.'/all-messages'."><b>?</b></a> | $count</p>";
		} else {
			
			return "<p>$c[hello], <a href=".$home.$lang.'/my-profile'.">$user</a> | <b>$date</b> | $c[message_of_day]: <b>$result[$message]</b> | <a href=".$home.$lang.'/all-messages'."><b>?</b></a> | $count</p>";
		}
	}

	static private function Main() {
		
		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$default_content = parent::$_default_content;

	    $content1 = (isset($_GET['content1'])) ? $_GET['content1'] : $default_content;
	    $content2 = (isset($_GET['content2'])) ? $_GET['content2'] : 1;
	    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
	    $op1 = (isset($_GET['op1'])) ? $_GET['op1'] : 1;
	    $op2 = (isset($_GET['op2'])) ? $_GET['op2'] : 1;
		
		$c = Language::LangPart('main');
		$usertype = $_SESSION[$site]['usertype'];
		$lang = $userlang = $_SESSION[$site]['userlang'];

		if (file_exists('engine/inc/'.$content1.'.inc.php')) {

			require_once 'engine/inc/'.$content1.'.inc.php';
			return $output;
			//
		} else {
			
			if ($content1 == 'check-email') {
			
				return "
					<h1>$c[success]</h1>
					<p>$c[check_email]</p>
				";
			} else if ($content1 === 'delete-all-messages-success') {
				
				return "
					<h1>$c[success]</h1>
					<p>$c[delete_all_messages_success]</p>
				";
			} else if ($content1 === 'delete-old-messages-success') {
				
				return "
					<h1>$c[success]</h1>
					<p>$c[delete_old_messages_success]</p>
				";
			} else if ($content1 === 'change-usertype-success') {
				
				return "
					<h1>$c[success]</h1>
					<p>$c[change_usertype_success]</p>
				";
			} else if ($content1 === 'add-cat-success') {
				
				return "
					<h1>$c[success]</h1>
					<p>$c[add_cat_success]</p>
				";
			} else if ($content1 === 'write-art-success') {
				
				return "
					<h1>$c[success]</h1>
					<p>$c[write_art_success]</p>
				";
			} else if ($content1 === 'update-art-success') {
				
				return "
					<h1>$c[success]</h1>
					<p>$c[update_art_success]</p>
				";
			} else if ($content1 === 'delete-success') {
				
				return "
					<h1>$c[success]</h1>
					<p>$c[delete_success]</p>
				";
			} else if ($content1 === 'block-success') {
				
				return "
					<h1>$c[success]</h1>
					<p>$c[block_success]</p>
				";
			} else if ($content1 === 'sent-success') {
				
				return "
					<h1>$c[success]</h1>
					<p>$c[mail_sent_success]</p>
				";
			} else if ($content1 === 'delete-member-success') {

				return "
					<h1>$c[success]</h1>
					<p>$c[member_deleted_success]</p>
				";
			} else {
				
				$link = new DB();

				$frk = BasicConfig::$_prefix;
				$categories = $frk.'categories';
				$articles = $frk.'articles';

				$query = "SELECT * FROM $categories JOIN $articles ON $categories.cat_id = $articles.category_id AND $categories.cat_seo_name = ? AND $articles.seo = ?";
				$result = $link->GetRow($query, [$content1, $content2]);

				if (!empty($result)) {

					require_once 'engine/inc/article.inc.php';
					return $output;
					//
				}
			}
		}	
	}

	static private function Right() {
		
		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$default_content = parent::$_default_content;

	    $content1 = (isset($_GET['content1'])) ? $_GET['content1'] : $default_content;
		$lang = $userlang = $_SESSION[$site]['userlang'];
		
		$c = Language::LangPart('main');
		
		require 'engine/inc/right.php';
		return $output;
	}

	static private function Left() {
		
		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$default_content = parent::$_default_content;

	    $content1 = (isset($_GET['content1'])) ? $_GET['content1'] : $default_content;
		$lang = $userlang = $_SESSION[$site]['userlang'];
		
		$c = Language::LangPart('main');
		
		require 'engine/inc/left.php';
		return $output;
	}

	static private function Footer() {
		
		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$lang = $userlang = $_SESSION[$site]['userlang'];

		$c = Language::LangPart('main');

		require 'engine/inc/footer.php';
		return $output;
	}

	static private function Banner() {

		return "
			
		";	
	}
}

?>