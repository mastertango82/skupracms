<?php

class Installation extends BasicConfig {
	
	static public function Options() {

		$languages = scandir('../languages');

		$options = '';

		foreach ($languages as $language) {

			if ($language != '.' AND $language != '..') {

				if ($language == $_SESSION['language']) {
			
					$selected = 'selected';
				} else {

					$selected = '';
				}

				$options .= "<option $selected value='".$language."'>$language</option>";	
			}
		}

		return $options;
	}

	static public function Submit() {

		require '../languages/'.$_SESSION['language'].'/installation.php';

		if (isset($_POST['sublang'])) {

			$_SESSION['language'] = $_POST['lang'];
		}

		if (isset($_POST['step3'])) {

			$host = $_POST['host'];
			$dbuser = $_POST['dbuser'];
			$dbpass = $_POST['dbpass'];
			$dbname = $_POST['dbname'];
			$dbprefix = $_POST['dbprefix'];

			if (empty($host) OR empty($dbuser) OR empty($dbname)) {

				return $l['empty'];
			} else {

				if (preg_match('/\s/', $host) OR preg_match('/\s/', $dbuser) OR preg_match('/\s/', $dbpass) OR preg_match('/\s/', $dbname) OR preg_match('/\s/', $dbprefix)) {

					return $l['no_space'];
				} else {

					$url = 'https://'.$_SERVER['HTTP_HOST'];
					$url = $url.$_SERVER['REQUEST_URI'];
					$url = explode('/', $url);
					array_pop($url);
					array_pop($url);
					$url = implode('/', $url);
					$url = $url.'/';

					$home = $_SERVER['REQUEST_URI'];
					$home = explode('/', $home);
					array_pop($home);
					array_pop($home);
					$home = implode('/', $home);
					$home = $home.'/';

					$site = 'skupra_'.rand(100, 999);

					$config = fopen("../basic-config.php", "w");

$data = "<?php\n
class BasicConfig {\n
	static protected ".'$_host'." = '$host';
	static protected ".'$_username'." = '$dbuser';
	static protected ".'$_password'." = '$dbpass';
	static protected ".'$_dbname'." = '$dbname';
	static public ".'$_prefix'." = '$dbprefix';\n
	static public ".'$_url'." = '$url';
	static public ".'$_home'." = '$home';\n
	static public ".'$_site'." = '$site';
}\n
?>
";

				$w = fwrite($config, $data);

					if ($w) {
						
						$_SESSION['message1'] = $l['message1'];

						header("Location: step4");
					}
				}
			}
		}

		if (isset($_POST['submit_6'])) {

			$error = 0;
			
			$username = $_POST['username'];
			$password = $_POST['password'];

			$session = md5(microtime(TRUE));

			if (empty($username) OR empty($password)) {

				return $l['empty'];
				$error = 1;
			} else {

				if ((mb_strlen($username, 'UTF-8') < 3) OR (mb_strlen($username, 'UTF-8') > 20)) {
						
					return $l['us_leng'];
					$error = 1;
				} 
				
				if (preg_match('/\s/',$username)) {
						
					return $l['us_space'];
					$error = 1;
				}

				if ((mb_strlen($password, 'UTF-8') < 3) OR (mb_strlen($password, 'UTF-8') > 20)) {
						
					return $l['pass_leng'];
					$error = 1;
				} 
				
				if (preg_match('/\s/',$password)) {
						
					return $l['pass_space'];
					$error = 1;
				}

				if ($error == 0) {

					$frk = BasicConfig::$_prefix;

					$users = $frk.'users';

					$link = new DB();

					$query = "INSERT INTO $users (session, username, usertype, userlang, password) VALUES (?, ?, ?, ?, ?)";
					$result = $link->InsertRow($query, [$session, $username, 4, 'sr-ci', md5($password)]);

					if (!empty($result)) {

						$_SESSION['username'] = $username;
						$_SESSION['password'] = $password;
						
						header("Location: step7");
					}
				}
			}
		}
	}

	static public function Check() {

		require '../languages/'.$_SESSION['language'].'/installation.php';

		$modules = apache_get_modules();
		
		if (in_array('mod_rewrite', $modules)) {

			$c['mod'] = $l['mod_enable'];
			$c['step_mod'] = 1;
		} else {

			$c['mod'] = $l['mod_not_enable'];
			$c['step_mod'] = 0;
		}

		if (is_writable('../basic-config.php')) {
			
			$c['config'] = $l['writable'];
			$c['step_config'] = 1;
		} else {

			$c['config'] = $l['not_writable'];
			$c['step_config'] = 0;
		}

		return $c;
	}

	static public function Create() {
		
		require '../languages/'.$_SESSION['language'].'/installation.php';
		
		$link = new DB();

		$dbname = parent::$_dbname;
		$prf = parent::$_prefix;

		$query = "ALTER DATABASE $dbname CHARACTER SET utf8 COLLATE utf8_general_ci";
		
		$result = $link->UpdateRow($query);
	
		$query1 ="
			CREATE TABLE `".$prf."articles` (
			`article_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`seo` varchar(128) NOT NULL,
			`header_sr` varchar(128) NOT NULL,
			`body_sr` text NOT NULL,
			`header_en` varchar(128) NOT NULL,
			`body_en` text NOT NULL,
			`author_id` int(11) NOT NULL,
			`category_id` int(11) NOT NULL,
			`like_article` int(11) NOT NULL DEFAULT '0',
			`dislike_article` int(11) NOT NULL DEFAULT '0',
			`multi_lang` int(1) NOT NULL DEFAULT '0',
			`favorite` int(1) NOT NULL DEFAULT '0',
			`odate_ar` date NOT NULL,
			`footer` int(1) NOT NULL DEFAULT '0',
			`publish` int(1) NOT NULL DEFAULT '1'
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT
		";

		$result = $link->UpdateRow($query1);

		$query2 = "
			CREATE TABLE `".$prf."blocked` (
			`ipid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`ip` varchar(32) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";

		$result = $link->UpdateRow($query2);

		$query3 = "
			CREATE TABLE `".$prf."categories` (
			`cat_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`cat_name_sr` varchar(70) NOT NULL,
			`cat_name_en` varchar(70) NOT NULL,
			`cat_description_sr` varchar(255) NOT NULL,
			`cat_description_en` varchar(255) NOT NULL,
			`num_art` int(11) NOT NULL DEFAULT '0',
			`cat_seo_name` varchar(70) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT
		";

		$result = $link->UpdateRow($query3);

		$query4 = "
			CREATE TABLE `".$prf."comments` (
			`com_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`artic_id` int(11) NOT NULL,
			`user` int(11) NOT NULL,
			`datetimes` datetime NOT NULL,
			`comment` varchar(200) NOT NULL,
			`userip` varchar(32) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		";

		$result = $link->UpdateRow($query4);

		$query5 = "
			CREATE TABLE `".$prf."linemessages` (
			`message_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`message_date` varchar(16) NOT NULL,
			`message_sr` varchar(200) NOT NULL,
			`message_en` varchar(200) NOT NULL,
			`show_mess` int(1) NOT NULL DEFAULT '0'
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT
		";

		$result = $link->UpdateRow($query5);

		$query6 = "
			CREATE TABLE `".$prf."online` (
			`online_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`otime` varchar(16) NOT NULL,
			`session` varchar(32) NOT NULL,
			`user` int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT
		";

		$result = $link->UpdateRow($query6);

		$query7 = "
			CREATE TABLE `".$prf."pmessages` (
			`message_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`sender` int(11) NOT NULL,
			`receiver` int(11) NOT NULL,
			`message` varchar(255) NOT NULL,
			`date_time` varchar(32) NOT NULL,
			`time_un` int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT
		";

		$result = $link->UpdateRow($query7);

		$query8 = "
			CREATE TABLE `".$prf."statuses` (
			`status_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`date_time` varchar(32) NOT NULL,
			`username` varchar(32) NOT NULL,
			`userip` varchar(32) NOT NULL,
			`status` varchar(200) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT
		";

		$result = $link->UpdateRow($query8);

		$query9 = "
			CREATE TABLE `".$prf."users` (
			`userid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`usertype` int(1) NOT NULL,
			`userlang` varchar(8) NOT NULL,
			`username` varchar(32) NOT NULL,
			`session` varchar(32) NOT NULL,
			`password` varchar(32) NOT NULL,
			`gender` varchar(16) NOT NULL,
			`birth` int(4) DEFAULT NULL,
			`like_user` int(11) NOT NULL DEFAULT '0',
			`dislike_user` int(11) NOT NULL DEFAULT '0',
			`name` varchar(32) NOT NULL,
			`lastname` varchar(32) NOT NULL,
			`email` varchar(128) NOT NULL,
			`website` varchar(128) NOT NULL,
			`signature` varchar(64) NOT NULL,
			`description` varchar(200) NOT NULL,
			`date_reg` date NOT NULL,
			`num_art` int(11) NOT NULL DEFAULT '0',
			`avatar` varchar(255) NOT NULL DEFAULT 'no-picture.jpg'
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT
		";

		$result = $link->UpdateRow($query9);

		return $l['table_created'];	
	}
}

?>