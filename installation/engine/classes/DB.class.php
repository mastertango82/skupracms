<?php

class DB extends BasicConfig {

	public $connection;
	protected $link;

	public function __construct() {

		$host 		= parent::$_host;
		$username 	= parent::$_username;
		$password 	= parent::$_password;
		$dbname 	= parent::$_dbname;

		$this->connection = TRUE;

		try {
			$this->link = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password);
			$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		}
		catch (PDOException $ex) {
			
			echo self::Error();
			exit();
		}
	}

	public function UpdateRow($query, $params = []) {
		try {
			$stmt = $this->link->prepare($query);
			$stmt->execute($params);
			return $stmt->rowCount();
		}
		catch (PDOException $ex) {
			throw new Exception($ex->getMessage());
		}
	}

	public function InsertRow($query, $params = []) {
		try {
			$stmt = $this->link->prepare($query);
			$stmt->execute($params);
			return $stmt->rowCount();
		}
		catch (PDOException $ex) {
			throw new Exception($ex->getMessage());
		}
	}
	
	static private function Error() {

		require '../languages/'.$_SESSION['language'].'/installation.php';
		
		$session = new Session();

		$submit = Installation::Submit();
		
		return "
			<!doctype html>
			<html>
			<head>
				<meta charset='utf-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1.0'>
				<link rel='icon' type='image/png' href='../favicon.png'>
				<link rel='stylesheet' type='text/css' href='../look/css/installation.css'>
				<title>$l[title]</title>
			</head>

			<body>
				<div id='install'>
					<img src='../look/img/logo-black.png'>
					<h1>$l[title]</h1>
					<p>$l[db_error]</p>
					<p>
						<a href='step3'>$l[step_3]</a>
					</p>
				</div>
			</body>
			</html>
		";
	}
}

?>