<?php

class Session extends ExtraConfig {

	public function __construct() {

		if (session_id() === '') {

			session_start();
			ob_start();
		} else {

			ob_start();
		}
	}

	public function Start() {

		$site = BasicConfig::$_site;

		$userip = self::GetUserIP();
		$guestsession = self::GetGuestSession();

		if ($userip === 'blocked') {

			die ('Ваша ИП адреса је блокирана!');
		} else {

			if (isset($_COOKIE[$site])) {
				
				if (isset($_SESSION[$site])) {
					
					// ok
				} else {

					$data = self::GetDataFromCookie();
					
					if ($data === false) {

						die ('Ваш колачић је неисправан. Очистите кеш!');
					} else {
						
						$_SESSION[$site] = array(

							'session'		=> $data['session'],
							'userid'		=> $data['userid'],
							'userip'		=> $userip,
							'userlang'		=> $data['userlang'],
							'usertype'		=> $data['usertype'],
							'username'		=> $data['username'],
							'likearticles'	=> array(),
							'likeusers'		=> array(),
							'var'			=> array()
						);
					}
				}
			} else {
				
				if (isset($_SESSION[$site])) {
					
					// ok
				} else {

					$_SESSION[$site] = array(

						'session'		=> $guestsession,
						'userid'		=> '0',
						'userip'		=> $userip,
						'userlang'		=> 'sr-ci',
						'usertype'		=> '0',
						'username'		=> 'Guest',
						'likearticles'	=> array(),
						'likeusers'		=> array(),
						'var'			=> array()
					);
				}
			}
		}
	}

	static public function GetUserIP() {

		$ip = '';
		
		if (getenv('HTTP_CLIENT_IP')) {
			
			$ip = getenv('HTTP_CLIENT_IP');
		} else if(getenv('HTTP_X_FORWARDED_FOR')) {
			
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} else if(getenv('HTTP_X_FORWARDED')) {
			
			$ip = getenv('HTTP_X_FORWARDED');
		} else if(getenv('HTTP_FORWARDED_FOR')) {
			
			$ip = getenv('HTTP_FORWARDED_FOR');
		} else if(getenv('HTTP_FORWARDED')) {
			
			$ip = getenv('HTTP_FORWARDED');
		} else if(getenv('REMOTE_ADDR')) {
			
			$ip = getenv('REMOTE_ADDR');
		} else {
			
			$ip = 'UNKNOWN';
		}

		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$blocked = $frk.'blocked';

		$query = "SELECT * FROM $blocked WHERE ip = ?";
		$result = $link->GetRow($query, [$ip]);

		if (!empty($result)) {
			
			return 'blocked';
		} else {
			
			return $ip;
		}
	}

	static private function GetDataFromCookie() {

		$site = BasicConfig::$_site;
		$cookie = $_COOKIE[$site];
		
		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$users = $frk.'users';

		$query = "SELECT session, userid, username, userlang, usertype FROM $users WHERE session = ?";
		$result = $link->GetRow($query, [$cookie]);

		if (!empty($result)) {
			
			return $result;
		} else {
			
			return false;
		}
	}

	static public function GetGuestSession() {

		return md5(microtime(true));
	}

	static public function Online() {

		$site = BasicConfig::$_site;
		$c = Language::LangPart('session');
		
		$min_members 	= parent::$_min_members;
		$max_members 	= parent::$_max_members;
		$min_guests 	= parent::$_min_guests;
		$max_guests		= parent::$_max_guests;

		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$online = $frk.'online';

		$otime = time();
		$pause = parent::$_online_pause;

		$query = "DELETE FROM $online WHERE otime + ? < ?";
		$result = $link->DeleteRow($query, [$pause, $otime]);

		$query2 = "SELECT * FROM $online WHERE session = ?";
		$result2 = $link->GetRow($query2, [$_SESSION[$site]['session']]);

		if (empty($result2)) {
			$query3 = "INSERT INTO $online (otime, session, user) VALUES (?, ?, ?)";
			$result3 = $link->InsertRow($query3, [$otime, $_SESSION[$site]['session'], $_SESSION[$site]['userid']]);
		} else {
			$query4 = "UPDATE $online SET otime = ? WHERE session = ?";
			$result4 = $link->UpdateRow($query4, [$otime, $_SESSION[$site]['session']]);
		}

		$query5 = "SELECT COUNT(*) FROM $online WHERE user != ?";
		$result5 = $link->GetRow($query5, [0]);

		$query6 = "SELECT COUNT(*) FROM $online WHERE user = ?";
		$result6 = $link->GetRow($query6, [0]);

		$_SESSION[$site]['var']['members'] = (isset($_SESSION[$site]['var']['members'])) ? $_SESSION[$site]['var']['members'] : rand($min_members, $max_members);
		$_SESSION[$site]['var']['guests'] = (isset($_SESSION[$site]['var']['guests'])) ? $_SESSION[$site]['var']['guests'] : rand($min_guests, $max_guests);

		$members = $result5['COUNT(*)'] + $_SESSION[$site]['var']['members']; // fejk members
		$guests = $result6['COUNT(*)'] + $_SESSION[$site]['var']['guests']; // fejk guests
		
		$total = $members + $guests;
		

		return $c['total_online']."<b>".$total."</b>".', '.$c['members_online']."<b>".$members."</b>";
	}
}

?>