<?php

class Session {
	
	public function __construct() {

		if (session_id() === '') {

			session_start();
			ob_start();
		} else {

			ob_start();
		}

		if (!isset($_SESSION['language'])) {
				
			$_SESSION['language'] = 'english';
		}
	}
}

?>