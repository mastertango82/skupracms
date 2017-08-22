<?php

class Engine extends ExtraConfig {
	
	static public function Signin() {

		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$error = array();
		$e = Language::LangPart('signin');

		if (isset($_POST['submit'])) {
			
			$username = $_POST['username'];
			$password = $_POST['password'];
			$remember = isset($_POST['remember']) ? 'on' : 'off';

			if ($username == '' AND $password == '') {
				$error[] = $e['fill'];
			} else {
				if ($username == '') {
					$error[] = $e['fill_username'];
				} else {
					if (mb_strlen($username, 'UTF-8') < 3) {
						$error[] = $e['us_leng_min'];
					} else if (mb_strlen($username, 'UTF-8') > 20) {
						$error[] = $e['us_leng_max'];
					}
					if (preg_match('/\s/',$username)) {
						$error[] = $e['us_space'];
					}
				}
				if ($password == '') {
					$error[] = $e['fill_pass'];
				} else {
					if (mb_strlen($password, 'UTF-8') < 3) {
						$error[] = $e['pass_leng_min'];
					} else if (mb_strlen($password, 'UTF-8') > 20) {
						$error[] = $e['pass_leng_max'];
					}
					if (preg_match('/\s/',$password)) {
						$error[] = $e['pass_space'];
					}
				}
			}

			if (empty($error)) {

				$link = new DB();

				$frk = BasicConfig::$_prefix;
				$users = $frk.'users';

				$password = md5($password);

				$query = "SELECT * FROM $users WHERE username = ? AND password = ? AND usertype != ?";
				$result = $link->GetRow($query, [$username, $password, -3]);

				if (!empty($result)) {
					if ($result['usertype'] == -2) {
						$error[] = $e['block_user'];
					}
					if ($result['usertype'] == -1) {
						$error[] = $e['noactiv_user'];
					}

					if (empty($error)) {

						$userip = Session::GetUserIP();
						
						$_SESSION[$site] = array(
							
							'session'		=> $result['session'],
							'userid'		=> $result['userid'],
							'userip'		=> $userip,
							'userlang'		=> $result['userlang'],
							'usertype'		=> $result['usertype'],
							'username'		=> $result['username'],
							'likearticles'	=> array(),
							'likeusers'		=> array(),
							'var'			=> array()
						);

						if ($remember == 'on') {
							setcookie($site, $result['session'], time()+3600*24*30, '/');
						}

						header ("Location: $home");
						exit();
					}
				} else {
					$error[] = $e['no_user'];
				}
			}
		}

		$errors = implode('<br>', $error);
		return $errors;
	}

	static public function Signup() {

		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;
		$url = BasicConfig::$_url;

		$lang = $_SESSION[$site]['userlang'];

		$error = array();
		$e = Language::LangPart('signup');

		if (isset($_POST['submit'])) {

			$username = $_POST['username'];
			$password = $_POST['password'];
			$password_again = $_POST['password_again'];
			$email = $_POST['email'];
			$gender = $_POST['gender'];

			if ($username == '' AND $password == '' AND $password_again == '' AND $email == '') {
				$error[] = $e['fill'];
			} else {	
				if ($username == '') {
					$error[] = $e['fill_username'];
				} else {
					if (mb_strlen($username, 'UTF-8') < 3) {
						$error[] = $e['us_leng_min'];
					} else if (mb_strlen($username, 'UTF-8') > 20) {
						$error[] = $e['us_leng_max'];
					}
					if (preg_match('/\s/',$username)) {
						$error[] = $e['us_space'];
					}
				}
				if ($password == $password_again) {
					
					if ($password == '') {
						$error[] = $e['fill_pass'];
					} else {
						if (mb_strlen($password, 'UTF-8') < 3) {
							$error[] = $e['pass_leng_min'];
						} else if (mb_strlen($password, 'UTF-8') > 20) {
							$error[] = $e['pass_leng_max'];
						}
						if (preg_match('/\s/',$password)) {
							$error[] = $e['pass_space'];
						}
					}
				} else {
					$error[] = $e['not_same'];
				}
				if ($email == '') {
					$error[] = $e['fill_email'];
				} else {
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$error[] = $e['fake_email'];
					}
				}

				if (empty($error)) {

					$link = new DB();

					$frk = BasicConfig::$_prefix;
					$users = $frk.'users';

					$query_u = "SELECT * FROM $users WHERE username = ?";
					$result_u = $link->GetRow($query_u, [$username]);
					
					$query_e = "SELECT * FROM $users WHERE email = ?";
					$result_e = $link->GetRow($query_e, [$email]);

					if (!empty($result_u)) {
						$error[] = $e['us_exist'];
					}
					if (!empty($result_e)) {
						$error[] = $e['email_exist'];
					}

					if (empty($error)) {

						$session = Session::GetGuestSession();
						$password = md5($password);
						$date_reg = date("Y-m-d");

						$query = "INSERT INTO $users (session, usertype, userlang, username, password, email, gender, date_reg) 
							VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
						$result = $link->InsertRow($query, [$session, -1, 'sr-ci', $username, $password, $email, $gender, $date_reg]);

						if ($result == 1) {

							$subject = $e['email_subject'];
							$link = $url.'activation/'.$session;
							$message = $e['email_message'].$link;

							mail($email, $subject, $message);
							header("Location: $home$lang".'/check-email');
							exit();
						}
					}
				}
			}
		}

		$errors = implode('<br>', $error);
		return $errors;
	}

	static public function Forgot() {
		
		$home = BasicConfig::$_home;
		$site = BasicConfig::$_site;
		$url = BasicConfig::$_url;

		$lang = $_SESSION[$site]['userlang'];

		$error = array();
		$e = Language::LangPart('forgot');

		if (isset($_POST['submit'])) {

			$email = $_POST['email'];

			if ($email == '') {
				$error[] = $e['fill_email'];
			} else {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$error[] = $e['fake_email'];
				}
			}

			if (empty($error)) {

				$link = new DB();

				$frk = BasicConfig::$_prefix;
				$users = $frk.'users';

				$query = "SELECT * FROM $users WHERE email = ?";
				$result = $link->GetRow($query, [$email]);

				if (!empty($result)) {
					
					$subject = $e['forg_subject'];
					$mlink = $url.'/new-password/'.$result['session'];
					$message = $e['mess1'].$result['username'].'. '.$e['mess2'].$mlink;

					mail($email, $subject, $message);
					header("Location: $home$lang".'/check-email');
					exit();
				} else {
					$error[] = $e['em_no_ex'];
				}
			}
		}

		$errors = implode('<br>', $error);
		return $errors;
	}

	static public function Activation() {

		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$error = array();
		$e = Language::LangPart('activation');

		if (isset($_GET['content2'])) {

			$link = new DB();

			$frk = BasicConfig::$_prefix;
			$users = $frk.'users';

			$query1 = "SELECT * FROM $users WHERE session = ? AND usertype = ?";
			$result1 = $link->GetRow($query1, [$_GET['content2'], -1]);

			if (!empty($result1)) {

				$query2 = "UPDATE $users SET usertype = ? WHERE session = ?";
				$result2 = $link->UpdateRow($query2, [1, $_GET['content2']]);

				if ($result2 == 1) {

					$userip = Session::GetUserIP();
					
					$_SESSION[$site] = array(

						'session'		=> $result1['session'],
						'userid'		=> $result1['userid'],
						'userip'		=> $userip,
						'userlang'		=> $result1['userlang'],
						'usertype'		=> '1',
						'username'		=> $result1['username'],
						'likearticles'	=> array(),
						'likeusers'		=> array(),
						'var'			=> array()
					);

					header ("Location: $home");
					exit();
				} else {
					$error[] = $e['act_try_ag'];
				}
			} else {
				$error[] = $e['act_mistake'];
			}
		} else {
			$error[] = $e['no_act'];
		}

		$errors = implode('<br>', $error);
		
		return $errors;
	}

	static public function NewPassword() {

		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$error = array();
		$e = Language::LangPart('newpassword');

		if (isset($_GET['content2'])) {

			$link = new DB();

			$frk = BasicConfig::$_prefix;
			$users = $frk.'users';

			$query1 = "SELECT * FROM $users WHERE session = ?";
			$result1 = $link->GetRow($query1, [$_GET['content2']]);

			if (!empty($result1)) {

				if (isset($_POST['submit'])) {

					$usertype1 = $result1['usertype'];

					$password = $_POST['password'];

					if ($password == '') {
						$error[] = $e['fill_pass'];
					} else {
						if (mb_strlen($password, 'UTF-8') < 3) {
							$error[] = $e['pass_leng_min'];
						} else if (mb_strlen($password, 'UTF-8') > 20) {
							$error[] = $e['pass_leng_max'];
						}
						if (preg_match('/\s/',$password)) {
							$error[] = $e['pass_space'];
						}
					}

					if (empty($error)) {
						
						if ($usertype1 == -2) {
							
							$error[] = $e['block_user'];
						} else if ($usertype1 == -1) {

							$error[] = $e['noactiv_user'];
						} else {

							$passwordmd5 = md5($password);

							$query2 = "UPDATE $users SET password = ? WHERE session = ?";
							$result2 = $link->UpdateRow($query2, [$passwordmd5, $_GET['content2']]);

							if (($result2 == 1) OR $result1['password'] == $passwordmd5) {

								$userip = Session::GetUserIP();

								$_SESSION[$site] = array(

									'session'		=> $result1['session'],
									'userid'		=> $result1['userid'],
									'userip'		=> $userip,
									'userlang'		=> $result1['userlang'],
									'usertype'		=> $result1['usertype'],
									'username'		=> $result1['username'],
									'likearticles'	=> array(),
									'likeusers'		=> array(),
									'var'			=> array()
								);

								header ("Location: $home");
								exit();
							}
						}
					}
				}
			} else {
				$error[] = $e['fake_code'];
			}
		} else {
			$error[] = $e['no_new_pass'];
		}

		$errors = implode('<br>', $error);
		return $errors;
	}

	static public function Profile($id) {

		$site = BasicConfig::$_site;
		$e = Language::LangPart('profile');

		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$users = $frk.'users';

		$query = "SELECT * FROM $users WHERE userid = ? AND usertype > ?";
		
		if ($_SESSION[$site]['usertype'] == 4) {
			
			$result = $link->GetRow($query, [$id, -4]);
		} else {
			
			$result = $link->GetRow($query, [$id, 0]);
		}

		if (!empty($result)) {
			
			$error = '';
		} else {
			
			$error = $e['no_user_data'];
		}

		$result['error'] = $error;
		
		return $result;
	}

	static public function EditProfile() {

		$site = BasicConfig::$_site;
		$data = Engine::Profile($_SESSION[$site]['userid']);
		$home = BasicConfig::$_home;
		
		$lang = $_SESSION[$site]['userlang'];

		$error = array();
		$e = Language::LangPart('profile');

		if ($data['error'] == '') {

			if (isset($_POST['submit'])) {

				$username = $_POST['username'];
				$password = $_POST['new_password'];
				$email = $_POST['email'];
				$name = $_POST['name'];
				$lastname = $_POST['lastname'];
				$birth = $_POST['birth'];
				$gender = $_POST['gender'];
				$signature = $_POST['signature'];
				$description = $_POST['description'];
				$website = $_POST['website'];

				if ($username == '') {
					$error[] = $e['fill_username'];
				} else {
					if (mb_strlen($username, 'UTF-8') < 3) {
						$error[] = $e['us_leng_min'];
					} else if (mb_strlen($username, 'UTF-8') > 20) {
						$error[] = $e['us_leng_max'];
					}
					if (preg_match('/\s/',$username)) {
						$error[] = $e['us_space'];
					}
				}

				if ($password != '') {
					
					if (mb_strlen($password, 'UTF-8') < 3) {
						$error[] = $e['pass_leng_min'];
					} else if (mb_strlen($password, 'UTF-8') > 20) {
						$error[] = $e['pass_leng_max'];
					}
					if (preg_match('/\s/',$password)) {
						$error[] = $e['pass_space'];
					}
				}

				if ($email == '') {
					$error[] = $e['fill_email'];
				} else {
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$error[] = $e['fake_email'];
					}
				}

				if (empty($error)) {
					
					$link = new DB();

					$frk = BasicConfig::$_prefix;
					$users = $frk.'users';

					if ($data['username'] != $username) {

						$query = "SELECT * FROM $users WHERE username = ?";
						$result = $link->GetRow($query, [$username]);

						if (!empty($result)) {
							$error[] = $e['us_exist'];
						}
					}
					if ($data['email'] != $email) {

						$query = "SELECT * FROM $users WHERE email = ?";
						$result = $link->GetRow($query, [$email]);

						if (!empty($result)) {
							$error[] = $e['email_exist'];
						}
					}

					if (empty($error)) {

						if ($_FILES['photo']['name']) {

							if ($_FILES['photo']['size'] > (1024000)) {

								$error[] = $e['to_large'];
							} else {
							
								$imageFileType = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

								if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
									$error[] = $e['error_image'];
								}
							}
						}

						if (empty($error)) {

							if ($_FILES['photo']['name'] == '') {
								
								$file = $data['avatar'];
							} else {
								
								$file = $data['userid'].basename($_FILES['photo']['name']);

								$target ='content/avatars/'.$file;
								move_uploaded_file($_FILES['photo']['tmp_name'], $target);
							}

							$avatar = $file;

							$link = new DB();

							if ($password == '') {
								$query = "UPDATE $users SET 
								username = ?, name = ?, lastname = ?, email = ?, birth = ?, gender = ?, signature = ?,
								 description = ?, website = ?, avatar = ? WHERE session = ?";

								$result = $link->UpdateRow($query, 
								[$username, $name, $lastname, $email, $birth, $gender,
								$signature, $description, $website, $avatar, $_SESSION[$site]['session']]);

								if ($result == 1) {
									header("Location: $home$lang".'/my-profile');
									exit();
								}
							} else {
								
								$password = md5($password);

								$query = "UPDATE $users SET 
								password = ?, username = ?, name = ?, lastname = ?, email = ?, birth = ?, gender = ?, signature = ?,
								 description = ?, website = ?, avatar = ? WHERE session = ?";

								$result = $link->UpdateRow($query, 
								[$password, $username, $name, $lastname, $email, $birth, $gender,
								$signature, $description, $website, $avatar, $_SESSION[$site]['session']]);

								if ($result == 1) {
									header("Location: $home$lang".'/my-profile');
									exit();
								}
							}
						}
					}
				}
			}
		}

		$errors = implode('<br>', $error);
		return $errors;
	}

	static public function DeletePrivateMessages() {

		if (isset($_POST['delete'])) {

			$link = new DB();

			$frk = BasicConfig::$_prefix;
			$pmessages = $frk.'pmessages';

			$t = time() - 2592000; // mesec dana
			$query = "DELETE FROM $pmessages WHERE time_un < ?";
			$result = $link->DeleteRow($query, [$t]);
		}
	}

	static public function SendMessage($receiver, $message) {

		$e = Language::LangPart('profile');

		$home = BasicConfig::$_home;
		$site = BasicConfig::$_site;

		$sender = self::UserId($_SESSION[$site]['username']);
		$receiver = self::UserId($receiver);
		$message = htmlspecialchars($message, ENT_QUOTES);
		$date_time = date("d.m.Y - H:i");
		$time_un = time();

		$lang = $_SESSION[$site]['userlang'];

		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$pmessages = $frk.'pmessages';

		if ($receiver === false) {
			return $e['no_user'];
		} else {
			
			$query = "INSERT INTO $pmessages SET time_un = ?, sender = ?, receiver = ?, date_time = ?, message = ?";
			$result = $link->InsertRow($query, [$time_un, $sender, $receiver, $date_time, $message]);
			
			if ($result == 1) {
				
				header("Location: $home$lang".'/private-messages');
				exit();
			}	
		}
	}

	static public function UserId($username) {

		$site = BasicConfig::$_site;

		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$users = $frk.'users';

		$query = "SELECT userid FROM $users WHERE username = ?";
		$result = $link->GetRow($query, [$username]);

		if (!empty($result)) {
			return $result['userid'];
		} else {
			return false;
		}
	}

	static public function UserFromId($id) {

		$site = parent::$_site;

		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$users = $frk.'users';
		
		$query = "SELECT username FROM $users WHERE userid = ?";
		$result = $link->GetRow($query, [$id]);

		if (!empty($result)) {
			return $result['username'];
		} else {
			return false;
		}
	}

	static public function Pagination($page, $num_page, $folder) {
		
		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;
		$default_content = parent::$_default_content;

		$lang = $_SESSION[$site]['userlang'];

		$content1 = (isset($_GET['content1'])) ? $_GET['content1'] : $default_content;
		$content2 = (isset($_GET['content2'])) ? $_GET['content2'] : 'new';
		$new = (isset($_GET['page'])) ? $_GET['page'] : 'new';
		
		$op1 = (isset($_GET['op1'])) ? $_GET['op1'] : 'new';

		if ($folder == '') {
			
			$folder = '/'.$content2.'/';
		} else if ($folder == 'archive') {

			$folder = '/'.$content2.'/'.$new.'/'.$op1.'/';
		} else {
			
			$folder = '/'.$content2.'/'.$new.'/';
		}

		if ($content1 == 'delete' OR $content1 == 'update' OR $content1 == 'all-messages' OR $content1 == 'delete-comment' OR $content1 == 'visitors') {

			$folder = '/';
		}

		$pag1 = "<div id='pagi'>";
		$pag2 = '';

		for($i=1;$i<=$num_page;$i++) {
			
			if($i==$page) {
				$pag2 .= "&nbsp;".$i."&nbsp;";
			} else {
				$pag2 .= "&nbsp;<a href='".$home.$lang.'/'.$content1.$folder.$i."'>".$i."</a>&nbsp;";
			}
		}
		
		$pag3 = '</div>';

		return $pag1.$pag2.$pag3;
	}

	static public function AddStatus($date_time, $status) {

		$site = BasicConfig::$_site;

		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$statuses = $frk.'statuses';

		$query = "INSERT INTO $statuses (date_time, userip, username, status) VALUES (?, ?, ?, ?)";
		$result = $link->InsertRow($query, [$date_time, $_SESSION[$site]['userip'], $_SESSION[$site]['username'], $status]);
	}

	static public function AddComment($datetimes, $comm, $article, $userip) {

		$link = new DB();
		$site = BasicConfig::$_site;

		$frk = BasicConfig::$_prefix;
		$comments = $frk.'comments';

		$query = "INSERT INTO $comments (datetimes, comment, artic_id, user, userip) VALUES (?, ?, ?, ?, ?)";
		$result = $link->InsertRow($query, [$datetimes, $comm, $article, $_SESSION[$site]['userid'], $userip]);
	}

	static public function SelectBox($cat_id) {

		$link = new DB();
		$site = BasicConfig::$_site;

		$frk = BasicConfig::$_prefix;
		$categories = $frk.'categories';

		$query = "SELECT * FROM $categories";
		$result = $link->GetRows($query);

		$output = '';

		foreach ($result as $cat) {
			
			if ($_SESSION[$site]['userlang'] === 'sr-ci' OR $_SESSION[$site]['userlang'] === 'sr-la') {
				$cat_name = 'cat_name_sr';
			} else {
				$cat_name = 'cat_name_en';
			}

			if ($cat_id != '') {
				if ($cat['cat_id'] == $cat_id) {
					$selected = 'selected';
				} else {
					$selected = '';
				}
			} else {
				$selected = '';
			}
			
			$output .= "
				<option value='$cat[cat_id]' $selected>$cat[$cat_name]</option>
			";
		}

		return $output;
	}

	static public function WriteArticle($header_sr, $header_en, $seo, $category_id, $body_sr, $body_en, $multi_lang, $favorite, $footer, $publish) {

		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		$e = Language::LangPart('edit');
		
		$lang = $_SESSION[$site]['userlang'];

		$odate_ar = date("Y-m-d");
		$author_id = self::UserId($_SESSION[$site]['username']);
		$header_sr = htmlspecialchars($header_sr, ENT_QUOTES);
		$header_en = htmlspecialchars($header_en, ENT_QUOTES);
		$seo = self::SEO($seo);

		$date = date("d-m-Y");
		$seo = $seo.'-'.$date;

		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$articles = $frk.'articles';
		$categories = $frk.'categories';
		$users = $frk.'users';

		$query0 = "SELECT * FROM $articles WHERE seo = ?";
		$result0 = $link->GetRow($query0, [$seo]);

		if (empty($result0)) {

			$query = "INSERT INTO $articles (seo, header_sr, body_sr, header_en, body_en, odate_ar,
											category_id, author_id, favorite, multi_lang, footer, publish) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$result = $link->InsertRow($query, [$seo, $header_sr, $body_sr, $header_en, $body_en, $odate_ar, 
											$category_id, $author_id, $favorite, $multi_lang, $footer, $publish]);


			if ($result == 1) {

				if ($publish == 1) {
					
					$query2 = "UPDATE $categories SET num_art = num_art + 1 WHERE cat_id = ?";
					$result2 = $link->UpdateRow($query2, [$category_id]);

					if ($result2 == 1) {
						
						$query3 = "UPDATE $users SET num_art = num_art + 1 WHERE userid = ?";
						$result3 = $link->UpdateRow($query3, [$author_id]);
					}

					if ($result3 == 1) {
						
						header("Location: $home$lang".'/write-art-success');
					}
				} else {

					header("Location: $home$lang".'/write-art-success');
				}
			}
		} else {
			return $e['seo_exists'];
		}
	}

	static private function SEO($input) {

		$cyr = array (
			"А" => "a", "Б" => "b", "В" => "v", "Г" => "g", "Д" => "d", "Ђ" => "dj", "Е" => "e", "Ж" => "z", "З" => "z", "И" => "i", 
			"Ј" => "j", "К" => "k", "Л" => "l", "Љ" => "lj", "М" => "m", "Н" => "n", "Њ" => "nj", "О" => "o", "П" => "p", "Р" => "r", 
			"С" => "s", "Т" => "t", "Ћ" => "c", "У" => "u", "Ф" => "f", "Х" => "h", "Ц" => "c", "Ч" => "c", "Џ" => "dz", "Ш" => "s", 

			"а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "ђ" => "dj", "е" => "e", "ж" => "z", "з" => "z", "и" => "i", 
			"ј" => "j", "к" => "k", "л" => "l", "љ" => "lj", "м" => "m", "н" => "n", "њ" => "nj", "о" => "o", "п" => "p", "р" => "r", 
			"с" => "s", "т" => "t", "ћ" => "c", "у" => "u", "ф" => "f", "х" => "h", "ц" => "c", "ч" => "c", "џ" => "dz", "ш" => "s"
		);

		$output = strtr($input, $cyr);
		$output = strtolower($output);
		$output = preg_replace("/[\s]/", "-", $output);
		$output = preg_replace("/[^a-z0-9-_]/",'',$output);

		return $output;
	}

	static public function UpdateArticle($author_id, $article_id, $header_sr, $header_en, $seo, $category_id, $body_sr, $body_en, $multi_lang, $favorite, $footer, $publish) {

		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;
		$e = Language::LangPart('edit');

		$lang = $_SESSION[$site]['userlang'];
		
		$header_sr = htmlspecialchars($header_sr, ENT_QUOTES);
		$header_en = htmlspecialchars($header_en, ENT_QUOTES);
		$seo = self::SEO($seo);

		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$articles = $frk.'articles';
		$categories = $frk.'categories';
		$users = $frk.'users';

		$query0 = "SELECT * FROM $articles WHERE seo = ? AND article_id != ?";
		$result0 = $link->GetRow($query0, [$seo, $article_id]);

		if (empty($result0)) {

			$query = "UPDATE $articles SET seo = ?, header_sr = ?, header_en = ?, body_sr = ?, body_en = ?, category_id = ?, 
							favorite = ?, multi_lang = ?, footer = ?, publish = ? WHERE article_id = ?";

			$result = $link->UpdateRow($query, [$seo, $header_sr, $header_en, $body_sr, $body_en, $category_id, 
							$favorite, $multi_lang, $footer, $publish, $article_id]);

			if ($result == 1) {

				if ($_SESSION[$site]['var']['article_publish'] == 1 AND $publish == 1) {

					if ($_SESSION[$site]['var']['cat_id'] != $category_id) {

						$query2 = "UPDATE $categories SET num_art = num_art - 1 WHERE cat_id = ?";
						$result2 = $link->UpdateRow($query2, [$_SESSION[$site]['var']['cat_id']]);

						if ($result2 == 1) {
							$query3 = "UPDATE $categories SET num_art = num_art + 1 WHERE cat_id = ?";
							$result3 = $link->UpdateRow($query3, [$category_id]);
						}
					}
				} else if ($_SESSION[$site]['var']['article_publish'] == 0 AND $publish == 0) {

					// ništa
				} else if ($_SESSION[$site]['var']['article_publish'] == 0 AND $publish == 1) {
	
					$query4 = "UPDATE $categories SET num_art = num_art + 1 WHERE cat_id = ?";
					$result4 = $link->UpdateRow($query4, [$category_id]);

					$query5 = "UPDATE $users SET num_art = num_art + 1 WHERE userid = ?";
					$result5 = $link->UpdateRow($query5, [$author_id]);
					
				} else if ($_SESSION[$site]['var']['article_publish'] == 1 AND $publish == 0) {

					if ($_SESSION[$site]['var']['cat_id'] != $category_id) {

						$query6 = "UPDATE $categories SET num_art = num_art - 1 WHERE cat_id = ?";
						$result6 = $link->UpdateRow($query6, [$_SESSION[$site]['var']['cat_id']]);
					} else {

						$query7 = "UPDATE $categories SET num_art = num_art - 1 WHERE cat_id = ?";
						$result7 = $link->UpdateRow($query7, [$category_id]);
					}

					$query8 = "UPDATE $users SET num_art = num_art - 1 WHERE userid = ?";
					$result8 = $link->UpdateRow($query8, [$author_id]);
				}

				header("Location: $home$lang".'/update-art-success');
			}
		} else {
			return $e['seo_exists'];
		}
	}

	static public function AddCategory($cat_name_sr, $cat_name_en, $cat_desc_sr, $cat_desc_en) {

		$home = BasicConfig::$_home;
		$site = BasicConfig::$_site;

		$e = Language::LangPart('edit');
		$seo = self::SEO($cat_name_sr);

		$lang = $_SESSION[$site]['userlang'];
		
		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$categories = $frk.'categories';

		$query = "SELECT * FROM $categories WHERE cat_seo_name = ?";
		$result = $link->GetRow($query, [$seo]);

		if (!empty($result)) {
			return $e['cat_exist'];
		} else {

			$query2 = "INSERT INTO $categories 
				(cat_seo_name, cat_name_sr, cat_description_sr, cat_name_en, cat_description_en) 
				VALUES (?, ?, ?, ?, ?)";
			$result = $link->InsertRow($query2, [$seo, $cat_name_sr, $cat_desc_sr, $cat_name_en, $cat_desc_en]);

			if ($result > 0) {
				header("Location: $home$lang".'/add-cat-success');
			}
		}
	}

	static public function UpdateCategory($cat_name_sr_old, $cat_name_sr, $cat_name_en, $cat_desc_sr, $cat_desc_en) {

		$home = BasicConfig::$_home;
		$site = BasicConfig::$_site;

		$lang = $_SESSION[$site]['userlang'];
		
		$e = Language::LangPart('edit');

		$seo = self::SEO($cat_name_sr);

		if ($cat_name_sr === $cat_name_sr_old) {
			$link = new DB();

			$frk = BasicConfig::$_prefix;
			$categories = $frk.'categories';
			
			$query = "UPDATE $categories SET cat_name_sr = ?, cat_name_en = ?, cat_description_sr = ?, cat_description_en = ? WHERE cat_id = ?";
			$result = $link->UpdateRow($query, [$cat_name_sr, $cat_name_en, $cat_desc_sr, $cat_desc_en, $_GET['content2']]);
			
			if ($result > 0) {
				header("Location: $home$lang".'/categories');
			}
		} else {
			$link = new DB();
			$query = "SELECT * FROM $categories WHERE cat_seo_name = ?";
			$result = $link->GetRow($query, [$seo]);

			if (!empty($result)) {
				return $e['cat_exist'];
			} else {
				$query = "UPDATE $categories SET cat_seo_name = ?, cat_name_sr = ?, cat_name_en = ?, cat_description_sr = ?, cat_description_en = ? WHERE cat_id = ?";
				$result = $link->UpdateRow($query, [$seo, $cat_name_sr, $cat_name_en, $cat_desc_sr, $cat_desc_en, $_GET['content2']]);

				if ($result > 0) {
					header("Location: $home$lang".'/categories');
				}
			}
		}
	}

	static public function NewMessage($message_sr, $message_en) {

		$e = Language::LangPart('edit');
		$site = BasicConfig::$_site;
		$home = BasicConfig::$_home;

		if (empty($message_sr) OR empty($message_en)) {
			$error = $e['empty_fields'];
		} else {

			if (strlen($message_sr) < 10 OR strlen($message_en) < 10 OR strlen($message_sr) > 190 OR strlen($message_en) > 190) {
				$error = $e['mess_leng'];
			} else {

				$link = new DB();

				$frk = BasicConfig::$_prefix;
				$linemessages = $frk.'linemessages';

				$message_date = date("d.m.Y");

				$query0 = "UPDATE $linemessages SET show_mess = 0 WHERE show_mess = 1";
				$result0 = $link->UpdateRow($query0);

				$query = "INSERT INTO $linemessages (message_date, message_sr, message_en, show_mess) VALUES (?, ?, ?, ?)";
				$result = $link->InsertRow($query, [$message_date, $message_sr, $message_en, 1]);

				if ($result == 1) {
					header ("Location: $home");
					exit();
				}
			}
		}

		return $error;
	}

	static public function UpdateLineMessages($id) {

		$home = BasicConfig::$_home;
		$site = BasicConfig::$_site;

		$lang = $_SESSION[$site]['userlang'];
		
		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$linemessages = $frk.'linemessages';

		$query0 = "SELECT * FROM $linemessages WHERE message_id = ?";
		$result0 = $link->GetRow($query0, [$id]);

		if (!empty($result0)) {
		
			$query1 = "UPDATE $linemessages SET show_mess = 0 WHERE show_mess = 1";
			$result1 = $link->UpdateRow($query1);
		
			$query2 = "UPDATE $linemessages SET show_mess = 1 WHERE message_id = ?";
			$result2 = $link->UpdateRow($query2, [$id]);

			header("Location: ".$home.$lang.'/all-messages');
			exit();
		}
	}

	static public function DeleteComm($id) {

		$home = BasicConfig::$_home;
		$site = BasicConfig::$_site;

		$lang = $_SESSION[$site]['userlang'];
		
		$link = new DB();

		$frk = BasicConfig::$_prefix;
		$comments = $frk.'comments';

		$query = "DELETE FROM $comments WHERE com_id = ?";
		$result = $link->DeleteRow($query, [$id]);

		header("Location: ".$home.$lang.'/delete-comment');
	}

	static public function DeleteMessages($what) {

		$home = BasicConfig::$_home;
		$site = BasicConfig::$_site;

		$lang = $_SESSION[$site]['userlang'];
		
		$e = Language::LangPart('edit');
		$old_mess_leave = parent::$_old_mess_leave;

		if (!is_numeric($what)) {

			if ($what == 'del_all') {

				$link = new DB();

				$frk = BasicConfig::$_prefix;
				$linemessages = $frk.'linemessages';
				
				$query = "DELETE FROM $linemessages";
				$result = $link->DeleteRow($query);

				if ($result > 0) {

					header ("Location: $home$lang".'/delete-all-messages-success');
				} else {
					return $e['delete_all_no'];
				}
			}

			if ($what == 'del_old') {

				$link = new DB();

				$frk = BasicConfig::$_prefix;
				$linemessages = $frk.'linemessages';
				
				$query0 = "SELECT COUNT(*) FROM $linemessages";
				$result0 = $link->GetRow($query0);

				$total = $result0['COUNT(*)'];

				if ($total > $old_mess_leave) {
					$limit = $total - $old_mess_leave;
				} else {
					$limit = 0;
				}

				$query = "DELETE FROM $linemessages ORDER BY message_id DESC LIMIT $limit";
				$result = $link->DeleteRow($query);

				if ($result > 0) {

					header ("Location: $home$lang".'/delete-old-messages-success');
				} else {
					return $e['delete_old_no'];
				}
			}
		} else {

			$link = new DB();

			$frk = BasicConfig::$_prefix;
			$linemessages = $frk.'linemessages';

			$query = "DELETE FROM $linemessages WHERE message_id = ?";
			$result = $link->DeleteRow($query, [$what]);

			header ("Location: ".$home.$lang.'/all-messages');
		}
	}
}

?>