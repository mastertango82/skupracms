<?php

class Language extends ExtraConfig {

	public function __construct() {

		$site = BasicConfig::$_site;

		if (!isset($_SESSION[$site]['var']['font'])) {
	    	$_SESSION[$site]['var']['font'] = 17;
	    }
    	if (isset($_POST['font1'])) {
			
			$_SESSION[$site]['var']['font'] = 17;
	    }
	    if (isset($_POST['font2'])) {
			
			$_SESSION[$site]['var']['font'] = 18;
	    }
	    if (isset($_POST['font3'])) {
			
			$_SESSION[$site]['var']['font'] = 19;
	    }

		if (isset($_GET['lang']) AND $_GET['lang'] == 'en') {
			
			$_SESSION[$site]['userlang'] = 'en';
		}
		if (isset($_GET['lang']) AND $_GET['lang'] == 'sr-ci') {
			
			$_SESSION[$site]['userlang'] = 'sr-ci';
		}
		if (isset($_GET['lang']) AND $_GET['lang'] == 'sr-la') {
			
			$_SESSION[$site]['userlang'] = 'sr-la';
		}
	}
	
	static public function LangPart($part) {

		$site = BasicConfig::$_site;

		if ($_SESSION[$site]['userlang'] == 'en') {
			
			$method = 'Lang'.ucfirst($part).'EN';
		} else if ($_SESSION[$site]['userlang'] == 'sr-ci' OR $_SESSION[$site]['userlang'] == 'sr-la') {

			$method = 'Lang'.ucfirst($part).'SR';
		} else {

			$method = 'Lang'.ucfirst($part).'SR';
		}

		return self::$method();
	}

	static private function LangMenuSR() {

		return $l = array(

			'home'				=> 'Почетна',
			'title'				=> 'ДНовиБлог',
			'key'				=> 'Кључ',
			'signin'			=> 'Пријави се',
			'signup'			=> 'Регистрација',
			'forgot'			=> 'Заборавили сте податке?',
			'favorites'			=> 'Фаворити',
			'categories'		=> 'Категорије',
			'statuses'			=> 'Статуси',
			'members'			=> 'Чланови',
			'language'			=> 'Језик',
			'serbian_cy'		=> 'Српски ћи',
			'serbian_la'		=> 'Српски ла',
			'english'			=> 'Енглески',
			'profile'			=> 'Профил',
			'edit_profile'		=> 'Промени податке',
			'change_password'	=> 'Промени лозинку',
			'add_avatar'		=> 'Додај аватар',
			'private_messages'	=> 'Приватне поруке',
			'logout'			=> 'Одјави се',
			'articles'			=> 'Чланци',
			'pictures'			=> 'Слике',
			'write'				=> 'Напиши чланак',
			'update'			=> 'Ажурирај чланак',
			'delete'			=> 'Избриши чланак',
			'see_categories'	=> 'Види категорије',
			'add_category'		=> 'Додај категорију',
			'update_category'	=> 'Ажурирај категорију',
			'delete_category'	=> 'Избриши категорију',
			'see_statuses'		=> 'Види статусе',
			'delete_statuses'	=> 'Избриши статусе',
			'see_members'		=> 'Види чланове',
			'change_usertype'	=> 'Промени тип члана',
			'message_day'		=> 'Порукe дана',
			'all_messages'		=> 'Све поруке',
			'new_message'		=> 'Нова порука',
			'delete_messages'	=> 'Избриши поруке',
			'my_profile'		=> 'Мој профил',
			'plus'				=> 'Плус',
			'visitors'			=> 'Посетиоци',
			'block_member'		=> 'Блокирај члана',
			'block_ip'			=> 'Блокирај ИП',
			'studio'			=> 'Студио',
			'font1'				=> 'Величина X',
			'font2'				=> 'Величина XX',
			'font3'				=> 'Величина XXL',
			'archives'			=> 'Архива',
			'delete_comment'	=> 'Брисање коментара',
			'downloads'			=> 'Преузимања',
			'auditorium'		=> 'Слушалица',
			'delete_member'		=> 'Избриши члана',
			'notpublished'		=> 'Необјављено',
			'ourworks'			=> 'Наши радови'
		);
	}

	static private function LangMenuEN() {

		return $l = array(

			'home'				=> 'Home',
			'title'				=> 'DNewBlog',
			'key'				=> 'Key',
			'signin'			=> 'Sign in',
			'signup'			=> 'Registration',
			'forgot'			=> 'Forgot your data?',
			'favorites'			=> 'Favorites',
			'categories'		=> 'Categories',
			'statuses'			=> 'Statuses',
			'members'			=> 'Members',
			'language'			=> 'Language',
			'serbian_cy'		=> 'Serbian cy',
			'serbian_la'		=> 'Serbian la',
			'english'			=> 'English',
			'profile'			=> 'Profile',
			'edit_profile'		=> 'Edit profile',
			'change_password'	=> 'Change password',
			'add_avatar'		=> 'Add avatar',
			'private_messages'	=> 'Private messages',
			'logout'			=> 'Logout',
			'articles'			=> 'Articles',
			'pictures'			=> 'Pictures',
			'write'				=> 'Write article',
			'update'			=> 'Update article',
			'delete'			=> 'Delete article',
			'see_categories'	=> 'See categories',
			'add_category'		=> 'Add category',
			'update_category'	=> 'Update category',
			'delete_category'	=> 'Delete category',
			'see_statuses'		=> 'See statuses',
			'delete_statuses'	=> 'Delete statuses',
			'see_members'		=> 'See members',
			'change_usertype'	=> 'Change user type',
			'message_day'		=> 'Daily messages',
			'all_messages'		=> 'All messages',
			'new_message'		=> 'New message',
			'delete_messages'	=> 'Delete messages',
			'my_profile'		=> 'My profile',
			'plus'				=> 'Plus',
			'visitors'			=> 'Visitors',
			'block_member'		=> 'Block member',
			'block_ip'			=> 'Block IP',
			'studio'			=> 'Studio',
			'font1'				=> 'Size X',
			'font2'				=> 'Size XX',
			'font3'				=> 'Size XXL',
			'archives'			=> 'Archives',
			'delete_comment'	=> 'Delete comment',
			'downloads'			=> 'Downloads',
			'auditorium'		=> 'Auditorium',
			'delete_member'		=> 'Delete member',
			'notpublished'		=> 'Not published',
			'ourworks'			=> 'Our works'
		);
	}

	static private function LangLineSR() {

		return $l = array(

			'message_of_day'	=> 'Порука дана',
			'last_status'		=> 'Последњи статус',
			'hello'				=> 'Здраво'
		);
	}

	static private function LangLineEN() {

		return $l = array(

			'message_of_day'	=> 'Daily message',
			'last_status'		=> 'Last status',
			'hello'				=> 'Hello'
		);
	}

	static private function LangSessionSR() {

		return $l = array(
			
			'total_online'		=> 'Укупно на вези: ',
			'members_online'	=> 'чланова: '
		);
	}

	static private function LangSessionEN() {

		return $l = array(
			
			'total_online'		=> 'Total online: ',
			'members_online'	=> 'members: '
		);
	}

	static private function LangMainSR() {

		$home = BasicConfig::$_home;

		return $l = array(

			'protected'			=> 'Забрањен приступ!',
			'signin'			=> 'Пријави се',
			'username'			=> 'Корисничко име',
			'password'			=> 'Лозинка',
			'password_again'	=> 'Понови лозинку',
			'remember'			=> 'Запамти ме ',
			'confirm'			=> 'Потврди',
			'no_content'		=> 'Нема садржаја',
			'email'				=> 'Е-пошта',
			'signup'			=> 'Регистрација',
			'man'				=> 'Мушко',
			'woman'				=> 'Женско',
			'forgot'			=> 'Заборавили сте податке?',
			'forgot_notice'		=> 'Ако сте заборавили подаке за пријаву, унесите е-пошту коју сте користили приликом регистрације.',
			'activation'		=> 'Активација',
			'new_password_guest'=> 'Нова лозинка',
			'check_email'		=> 'Проверите е-пошту и пратите упутство за приступ сајту.',
			'success'			=> 'Успех!',
			'member'			=> 'Члан',
			'author'			=> 'Аутор',
			'moderator'			=> 'Модератор',
			'administrator'		=> 'Администратор',
			'blockuser'			=> 'Блокиран корисник',
			'deleteduser'		=> 'Обрисани корисник',
			'name'				=> 'Име',
			'lastname'			=> 'Презиме',
			'signature'			=> 'Потпис',
			'website1'			=> 'Веб сајт, почиње са (http://)',
			'website2'			=> 'Веб сајт',
			'description'		=> 'Опис',
			'num_articles'		=> 'Број чланака',
			'my_profile'		=> 'Мој профил',
			'date_reg'			=> 'Регистрован/а',
			'language_def'		=> 'Језик на сајту',
			'edit_profile'		=> 'Промени профил',
			'serbian_cy'		=> 'Српски ћи',
			'serbian_la'		=> 'Српски ла',
			'english'			=> 'Енглески',
			'birth'				=> 'Година рођења',
			'avatar'			=> 'Твоја слика ',
			'gender'			=> 'Пол',
			'new_password'		=> 'Нова лозинка.<br>Ако не желиш да мењаш, остави празно!',
			'messages'			=> 'Приватне поруке',
			'sender'			=> 'Пошиљалац: ',
			'receiver'			=> 'Прималац: ',
			'add_mess'			=> 'Додај поруку',
			'add_rece'			=> 'Прималац',
			'empty_mess'		=> 'Попуните поља!',
			'delete_mess'		=> 'Избриши старе поруке',
			'mess_notice'		=> 'Поруке старије од месец дана се бришу',
			'order'				=> 'Поредак',
			'ord_new'			=> 'Новије прво',
			'ord_like'			=> 'Лајкови прво',
			'ord_dislike'		=> 'Дислајкови прво',
			'ord_old'			=> 'Старије прво',
			'all_articles'		=> 'Сви чланци',
			'order_like_ar'		=> 'Поредак: лајкови прво',
			'order_dislike_ar'	=> 'Поредак: дислајкови прво',
			'order_old_ar'		=> 'Поредак: старије прво',
			'order_new_ar'		=> 'Поредак: новије прво',
			'read_more'			=> 'Прочитај више',
			'favorites'			=> 'Фаворити',
			'categories'		=> 'Категорије',
			'statuses'			=> 'Статуси',
			'add_status'		=> 'Додај статус',
			'members'			=> 'Чланови',
			'articles_from'		=> 'Чланци од',
			'no_articles'		=> 'Нема чланака',
			'images'			=> 'Слике',
			'images_notice'		=> 'Све слике на серверу, се налазе овде: <a href='.$home.'content/img/'.'>content/img</a>',
			'your_photo'		=> 'Твоја слика',
			'write_article'		=> 'Напиши чланак',
			'header_sr'			=> 'Наслов на српском - ћирилица',
			'header_en'			=> 'Наслов на енглеском',
			'seo_header'		=> 'СЕО Наслов (линк)',
			'multi_lang'		=> 'Вишејезичност (Ен) ',
			'body_sr'			=> 'Српски текст',
			'body_en'			=> 'Енглески текст',
			'favorite'			=> 'Фаворизован чланак ',
			'write_art_success' => 'Успешно сте написали чланак.',
			'category'			=> 'Категорија',
			'update_article'	=> 'Ажурирај чланак',
			'update_art_success'=> 'Успешно сте ажурирали чланак.',
			'delete_article'	=> 'Брисање чланака',
			'delete_number'		=> 'Унесите број чланка, који желите да обришете!',
			'delete_success'	=> 'Чланак је успешно обрисан!',
			'del_ar_not'		=> 'Пажња! Једном обрисан чланак, не може бити враћен!',
			'add_category'		=> 'Додајте категорију',
			'fields_mand'		=> 'Сва поља су обавезна.',
			'cat_name_sr'		=> 'Име категорије на српском',
			'cat_name_en'		=> 'Име категорије на енглеском',
			'cat_desc_sr'		=> 'Опис на српском',
			'cat_desc_en'		=> 'Опис на енглеском',
			'add_cat_success'	=> 'Успешно додата категорија.',
			'delete_cat'		=> 'Брисање категорије',
			'del_cat_notice'	=> 'Можете избрисати само категорију без чланака!<br>
									Категорију бришете кликом на име!',
			'update_category'	=> 'Ажурирај категорију',
			'change_usertype'	=> 'Промена типа корисника',
			'let_it_be'			=> 'Нека буде: ',
			'change_usertype_success'	=> 'Тип корисника успешно промењен.',
			'new_message'		=> 'Нова порука',
			'message_sr'		=> 'Порука на српском',
			'message_en'		=> 'Порука на енглеском',
			'del_old'			=> 'Избриши старе поруке',
			'del_all'			=> 'Избриши све поруке',
			'del_old_s'			=> 'Избриши старе статусе',
			'del_all_s'			=> 'Избриши све статусе',
			'delete_all_messages_success'	=>	'Све поруке су обрисане.',
			'delete_old_messages_success'	=> 'Старе поруке су обрисане.',
			'delete_statuses'		=> 'Брисање статуса',
			'del_old_ok'			=> 'Успешно избрисани стари статуси!',
			'del_old_no'			=> 'Статуси нису избрисани!',
			'del_all_ok'			=> 'Успешно избрисани сви статуси!',
			'del_all_no'			=> 'Статуси нису избрисани!',
			'warning'				=> 'Пажња! Користите ову страну пажљиво.',
			'visitors'			=> 'Посетиоци',
			'vis_ip'			=> 'ИП адреса: ',
			'vis_lik_ar'		=> 'Лајкова чланака: ',
			'vis_dis_ar'		=> 'Дислајкова чланака: ',
			'vis_lik_us'		=> 'Лајкова корисника: ',
			'vis_dis_us'		=> 'Дислајкова корисника: ',
			'vis_status'		=> 'Број статуса: ',
			'del_free'			=> 'Брисање неактивних адреса',
			'block_member'		=> 'Блокирај члана',
			'block_success'		=> 'Успешно сте блокирали члана!',
			'block_ip'			=> 'Блокирај ИП адресу',
			'block_ip_yes'		=> 'Блокирана ИП адреса',
			'block_ip_not'		=> 'Нема блокираних адреса',
			'ban'				=> 'Блокирај ИП',
			'unblock'			=> 'Одобри ИП',
			'noactiv'			=> 'Неактивиран корисник',
			'all_messages'		=> 'Све поруке дана',
			'studio_skupra'		=> 'Веб Студио Скупра',
			'footer'			=> 'Футер',
			'archives'			=> 'Архива',
			'jan'				=> 'Јануар',
			'feb'				=> 'Фебруар',
			'mar'				=> 'Март',
			'apr'				=> 'Април',
			'maj'				=> 'Мај',
			'jun'				=> 'Јун',
			'jul'				=> 'Јул',
			'avg'				=> 'Август',
			'sep'				=> 'Септембар',
			'okt'				=> 'Октобар',
			'nov'				=> 'Новембар',
			'dec'				=> 'Децембар',
			'same_cat'			=> 'Чланци из исте категорије : ',
			'comm'				=> 'Коментари:',
			'guest'				=> 'Гост',
			'delete_comments'	=> 'Брисање коментара',
			'no_comments'		=> 'Нема коментара!',
			'com_notice'		=> 'Унесите редни број коментара који желите да избришете..',
			'all_mess_notice' 	=> 'Унеси редни број поруке за коју желиш да буде приказана.',
			'delete_messages'	=> 'Брисање дневних порука',
			'del_mess_not'		=> 'Унесите редни број поруке, коју желите да обришете..',
			'del_stat_not'		=> 'Унесите редни број статуса, који желите да обришете..',
			'downloads'			=> 'Преузимања',
			'auditorium'		=> 'Слушалица',
			'downloads_user'	=> 'Преузимања од: ',
			'auditorium_user'	=> 'Слушалица од: ',
			'copycopy'			=> 'Ово је непрофитабилан сајт, уметнички израз и није нам циљ да кршимо била чија ауторска права. - &copy; 2017. Скупра',
			'publish'			=> 'Објављено',
			'delete_member'		=> 'Избриши члана',
			'delete_member_not'	=> 'Можете трајно избрисати само чланове који немају објављених текстова!',
			'no_del_mem'		=> 'Не можете избрисати тог члана!',
			'member_deleted_success'	=> 'Успешно избрисан члан!',
			'notpublished'		=> 'Необјављено',
			'change_author'		=> 'Број чланка за који мењате аутора',
			'new_author'		=> 'Нови аутор',
			'ourworks'			=> 'Наши радови'
		);
	}

	static private function LangMainEN() {

		$home = BasicConfig::$_home;

		return $l = array(

			'protected'			=> 'Denied access!',
			'signin'			=> 'Sign in',
			'username'			=> 'Username',
			'password'			=> 'Password',
			'password_again'	=> 'Repeat password',
			'remember'			=> 'Remember me ',
			'confirm'			=> 'Confirm',
			'no_content'		=> 'No content',
			'email'				=> 'E-mail',
			'signup'			=> 'Sign up',
			'man'				=> 'Male',
			'woman'				=> 'Female',
			'forgot'			=> 'Forgot your data?',
			'forgot_notice'		=> 'If you have forgotten your data across the application, enter your e-mail you used when registering.',
			'activation'		=> 'Activation',
			'new_password_guest'=> 'New password',
			'check_email'		=> 'Check your email and follow the instructions to access the site.',
			'success'			=> 'Success!',
			'member'			=> 'Member',
			'author'			=> 'Author',
			'moderator'			=> 'Moderator',
			'administrator'		=> 'Administrator',
			'blockuser'			=> 'Blocked user',
			'deleteduser'		=> 'Deleted user',
			'name'				=> 'Name',
			'lastname'			=> 'Lastname',
			'signature'			=> 'Signature',
			'website1'			=> 'Web site begins with (http://)',
			'website2'			=> 'Web site',
			'description'		=> 'Description',
			'num_articles'		=> 'Number of articles',
			'my_profile'		=> 'My profile',
			'date_reg'			=> 'Registered',
			'language_def'		=> 'Language on site',
			'edit_profile'		=> 'Edit profile',
			'serbian_cy'		=> 'Serbian cy',
			'serbian_la'		=> 'Serbian la',
			'english'			=> 'English',
			'birth'				=> 'Birth year',
			'avatar'			=> 'Your avatar ',
			'gender'			=> 'Sex',
			'new_password'		=> 'New password.<br>If you do not want to change, leave empty!',
			'messages'			=> 'Private messages',
			'sender'			=> 'Sender: ',
			'receiver'			=> 'Receiver: ',
			'add_mess'			=> 'Add message',
			'add_rece'			=> 'Receiver',
			'empty_mess'		=> 'Fill the fields!',
			'delete_mess'		=> 'Delete old messages',
			'mess_notice'		=> 'Messages older than one month are deleted',
			'order'				=> 'Order',
			'ord_new'			=> 'Newest first',
			'ord_like'			=> 'Likes first',
			'ord_dislike'		=> 'Dislikes first',
			'ord_old'			=> 'Older first',
			'all_articles'		=> 'All articles',
			'order_like_ar'		=> 'Order: likes first',
			'order_dislike_ar'	=> 'Order: dislikes first',
			'order_old_ar'		=> 'Order: older first',
			'order_new_ar'		=> 'Order: newest first',
			'read_more'			=> 'Read more',
			'favorites'			=> 'Favorites',
			'categories'		=> 'Categories',
			'statuses'			=> 'Statuses',
			'add_status'		=> 'Add status',
			'members'			=> 'Members',
			'articles_from'		=> 'Articles from',
			'no_articles'		=> 'No articles',
			'images'			=> 'Images',
			'images_notice'		=> 'All images on server is here: <a href='.$home.'content/img/'.'>content/img</a>',
			'your_photo'		=> 'Your image',
			'write_article'		=> 'Write article',
			'header_sr'			=> 'Title in serbian - cyrillic',
			'header_en'			=> 'Title in english',
			'seo_header'		=> 'SEO title',
			'multi_lang'		=> 'Multilingualism (EN) ',
			'body_sr'			=> 'Serbian article',
			'body_en'			=> 'English article',
			'favorite'			=> 'Favored article ',
			'write_art_success' => 'You have successfully written the article.',
			'category'			=> 'Category',
			'update_article'	=> 'Update article',
			'update_art_success'=> 'You have successfully update the article.',
			'delete_article'	=> 'Delete article',
			'delete_number'		=> 'Enter the article number you want to delete!',
			'delete_success'	=> 'The article was successfully deleted!',
			'del_ar_not'		=> 'Attention! Once deleted the article can not be returned!',
			'add_category'		=> 'Add category',
			'fields_mand'		=> 'All fields are required.',
			'cat_name_sr'		=> 'Category name in serbian',
			'cat_name_en'		=> 'Category name in english',
			'cat_desc_sr'		=> 'Description in serbian',
			'cat_desc_en'		=> 'Description in english',
			'add_cat_success'	=> 'Successfully added category.',
			'delete_cat'		=> 'Delete category',
			'del_cat_notice'	=> 'You can only delete a category without articles!<br>
									Delete category by clicking on the name!',
			'update_category'	=> 'Update category',
			'change_usertype'	=> 'Change user type',
			'let_it_be'			=> 'Let it be: ',
			'change_usertype_success'	=> 'The type of user has been successfully changed.',
			'new_message'		=> 'New message',
			'message_sr'		=> 'Message in serbian',
			'message_en'		=> 'Message in english',
			'del_old'			=> 'Delete old messages',
			'del_all'			=> 'Delete all messages',
			'del_old_s'			=> 'Delete old statuses',
			'del_all_s'			=> 'Delete all statuses',
			'delete_all_messages_success'	=>	'All messages are deleted.',
			'delete_old_messages_success'	=> 'Old messages are deleted.',
			'delete_statuses'		=> 'Delete statuses',
			'del_old_ok'			=> 'Old statuses are deleted!',
			'del_old_no'			=> 'Statuses not deleted!',
			'del_all_ok'			=> 'All statuses are deleted!',
			'del_all_no'			=> 'Statuses not deleted!',
			'warning'				=> 'Attention! Use this side carefully.',
			'visitors'			=> 'Visitors',
			'vis_ip'			=> 'IP address: ',
			'vis_lik_ar'		=> 'Likes articles: ',
			'vis_dis_ar'		=> 'Dislikes articles: ',
			'vis_lik_us'		=> 'Likes users: ',
			'vis_dis_us'		=> 'Dislikes users: ',
			'vis_status'		=> 'Number of statuses: ',
			'del_free'			=> 'Delete nonactive address',
			'block_member'		=> 'Block member',
			'block_success'		=> 'You successfully blocked member!',
			'block_ip'			=> 'Block IP address',
			'block_ip_yes'		=> 'Blocked IP address',
			'block_ip_not'		=> 'No blocked address',
			'ban'				=> 'Block IP',
			'unblock'			=> 'Unblock IP',
			'noactiv'			=> 'Nonactive user',
			'all_messages'		=> 'All daily messages',
			'studio_skupra'		=> 'Web Studio Skupra',
			'footer'			=> 'Footer',
			'archives'			=> 'Archives',
			'jan'				=> 'January',
			'feb'				=> 'February',
			'mar'				=> 'March',
			'apr'				=> 'April',
			'maj'				=> 'May',
			'jun'				=> 'June',
			'jul'				=> 'July',
			'avg'				=> 'August',
			'sep'				=> 'September',
			'okt'				=> 'October',
			'nov'				=> 'November',
			'dec'				=> 'December',
			'same_cat'			=> 'Articles from the same category : ',
			'comm'				=> 'Comments:',
			'guest'				=> 'Guest',
			'delete_comments'	=> 'Delete comments',
			'no_comments'		=> 'No comments!',
			'com_notice'		=> 'Enter the serial number of comments you want to delete..',
			'all_mess_notice' 	=> 'Enter the serial number of the message for which you want to be shown.',
			'delete_messages'	=> 'Deleting messages daily',
			'del_mess_not'		=> 'Enter the serial number of the message you want to delete..',
			'del_stat_not'		=> 'Enter the serial number of the statuses you want to delete..',
			'downloads'			=> 'Downloads',
			'auditorium'		=> 'Auditorium',
			'downloads_user'	=> 'Downloads from: ',
			'auditorium_user'	=> 'Auditorium from: ',
			'copycopy'			=> 'This is not profitabilan site, artistic expression and our goal is not to violate been copyrighted. - &copy; 2017. Skupra',
			'publish'			=> 'Publish',
			'delete_member'		=> 'Delete member',
			'delete_member_not'	=> 'You can permanently delete only the members who not have published articles!',
			'no_del_mem'		=> 'You can not delete this member!',
			'member_deleted_success'	=> 'Successfully deleted member!',
			'notpublished'		=> 'Not published',
			'change_author'		=> 'Article number you want to edit the author',
			'new_author'		=> 'New author',
			'ourworks'			=> 'Our works'
		);
	}

	static private function LangSigninSR() {

		return $l = array(

			'fill'				=> 'Попуните поља!',
			'fill_username'		=> 'Унесите корисничко име!',
			'us_leng_min'		=> 'Корисничко име мора имати више од 2 карактера!',
			'us_leng_max'		=> 'Корисничко име не сме имати више од 20 карактера!',
			'us_space'			=> 'Корисничко име не сме садржати празан карактер!',
			'fill_pass'			=> 'Унесите лозинку!',
			'pass_leng_min'		=> 'Лозинка мора имати више од 2 карактера!',
			'pass_leng_max'		=> 'Лозинка не сме имати више од 20 карактера!',
			'pass_space'		=> 'Лозинка не сме садржати празан карактер!',
			'block_user'		=> 'Ваш налог је блокиран!',
			'noactiv_user'		=> 'Нисте активирали налог путем е-поште!',
			'no_user'			=> 'Не постојећи корисник!'
		);
	}

	static private function LangSigninEN() {

		return $l = array(

			'fill'				=> 'Fill the fields!',
			'fill_username'		=> 'Please enter a username!',
			'us_leng_min'		=> 'The username must have more than 2 characters!',
			'us_leng_max'		=> 'The username must not have more than 20 characters!',
			'us_space'			=> 'The username must not contain a blank character!',
			'fill_pass'			=> 'Enter your password!',
			'pass_leng_min'		=> 'The password must have more than 2 characters!',
			'pass_leng_max'		=> 'The password must not have more than 20 characters!',
			'pass_space'		=> 'The password must not contain a blank character!',
			'block_user'		=> 'Your account is blocked!',
			'noactiv_user'		=> 'You have not activated your account via e-mail!',
			'no_user'			=> 'No existing user!'
		);
	}

	static private function LangSignupSR() {

		return $l = array(

			'fill'				=> 'Попуните поља!',
			'fill_username'		=> 'Унесите корисничко име!',
			'us_leng_min'		=> 'Корисничко име мора имати више од 2 карактера!',
			'us_leng_max'		=> 'Корисничко име не сме имати више од 20 карактера!',
			'us_space'			=> 'Корисничко име не сме садржати празан карактер!',
			'fill_pass'			=> 'Унесите лозинку!',
			'pass_leng_min'		=> 'Лозинка мора имати више од 2 карактера!',
			'pass_leng_max'		=> 'Лозинка не сме имати више од 20 карактера!',
			'pass_space'		=> 'Лозинка не сме садржати празан карактер!',
			'not_same'			=> 'Лозинке се не подударају!',
			'fill_email'		=> 'Унесите важећу е-пошту!',
			'fake_email'		=> 'Неважећа е-пошта!',
			'us_exist'			=> 'То корисничко име већ постоји у нашој бази!',
			'email_exist'		=> 'Та е-пошта већ постоји у нашој бази!',
			'email_subject'		=> 'Активација корисничког налога',
			'email_message'		=> 'Да би сте активирали налог, кликните на следећи линк: '
		);	
	}

	static private function LangSignupEN() {

		return $l = array(

			'fill'				=> 'Fill the fields!',
			'fill_username'		=> 'Please enter a username!',
			'us_leng_min'		=> 'The username must have more than 2 characters!',
			'us_leng_max'		=> 'The username must not have more than 20 characters!',
			'us_space'			=> 'The username must not contain a blank character!',
			'fill_pass'			=> 'Enter your password!',
			'pass_leng_min'		=> 'The password must have more than 2 characters!',
			'pass_leng_max'		=> 'The password must not have more than 20 characters!',
			'pass_space'		=> 'The password must not contain a blank character!',
			'not_same'			=> 'The passwords do not match!',
			'fill_email'		=> 'Please enter valid email!',
			'fake_email'		=> 'Invalid email!',
			'us_exist'			=> 'This username already exists in our database!',
			'email_exist'		=> 'This email already exists in our database!',
			'email_subject'		=> 'Activating the user account',
			'email_message'		=> 'To activate your account click on the following link: '
		);	
	}

	static private function LangActivationSR() {

		return $l = array(

			'no_act'			=> 'Грешка. Нема активације!',
			'act_mistake'		=> 'Грешка. Погрешан активациони код!',
			'act_try_ag'		=> 'Грешка. Покушајте поново!'
		);
	}

	static private function LangActivationEN() {

		return $l = array(

			'no_act'			=> 'Error. No activation!',
			'act_mistake'		=> 'Error. Incorrect activation code!',
			'act_try_ag'		=> 'Error. Please try again!'
		);
	}

	static private function LangForgotSR() {

		return $l = array(

			'fill_email'		=> 'Унесите важећу е-пошту!',
			'fake_email'		=> 'Неважећа е-пошта!',
			'em_no_ex'			=> 'Та е-пошта не постоји у нашој бази!',
			'forg_subject'		=> 'Подаци за пријаву',
			'mess1'				=> 'Ваше корисничко име је: ',
			'mess2'				=> ' Морате унети нову лозинку, стога кликните на следећи линк: '
		);
	}

	static private function LangForgotEN() {

		return $l = array(

			'fill_email'		=> 'Please enter valid email!',
			'fake_email'		=> 'Invalid email!',
			'em_no_ex'			=> 'This email does not exist in our database!',
			'forg_subject'		=> 'Login information',
			'mess1'				=> 'Your username is: ',
			'mess2'				=> ' You must enter a new password, so click the following link: '
		);
	}

	static private function LangNewpasswordSR() {

		return $l = array(

			'fill_pass'			=> 'Унесите лозинку!',
			'pass_leng_min'		=> 'Лозинка мора имати више од 2 карактера!',
			'pass_leng_max'		=> 'Лозинка не сме имати више од 20 карактера!',
			'pass_space'		=> 'Лозинка не сме садржати празан карактер!',
			'no_new_pass'		=> 'Грешка. Нема нове лозинке!',
			'fake_code'			=> 'Грешка. Погрешан активациони код!',
			'noactiv_user'		=> 'Нисте активирали налог путем е-поште!',
			'block_user'		=> 'Ваш налог је блокиран!'
		);
	}

	static private function LangNewpasswordEN() {

		return $l = array(

			'fill_pass'			=> 'Enter the password!',
			'pass_leng_min' 	=> 'Password must have more than 2 characters!',
			'pass_leng_max' 	=> 'Password must not have more than 20 characters!',
			'pass_space' 		=> 'The password can not contain a blank character!',
			'no_new_pass' 		=> 'Error. No new password!',
			'fake_code' 		=> 'Error. Wrong activation code!',
			'noactiv_user' 		=> 'You have not activated your account via e-mail!',
			'block_user' 		=> 'Your account has been blocked!'
		);
	}

	static private function LangProfileSR() {

		return $l = array(

			'no_user_data'		=> 'Нема података о овом кориснику!',
			'fill_username'		=> 'Унесите корисничко име!',
			'us_leng_min'		=> 'Корисничко име мора имати више од 2 карактера!',
			'us_leng_max'		=> 'Корисничко име не сме имати више од 20 карактера!',
			'us_space'			=> 'Корисничко име не сме садржати празан карактер!',
			'pass_leng_min'		=> 'Лозинка мора имати више од 2 карактера!',
			'pass_leng_max'		=> 'Лозинка не сме имати више од 20 карактера!',
			'pass_space'		=> 'Лозинка не сме садржати празан карактер!',
			'fill_email'		=> 'Унесите важећу е-пошту!',
			'fake_email'		=> 'Неважећа е-пошта!',
			'us_exist'			=> 'То корисничко име већ постоји у нашој бази!',
			'email_exist'		=> 'Та е-пошта већ постоји у нашој бази!',
			'to_large'			=> 'Слика је превелика (макс: 1мб)!',
			'error_image'		=> 'Грешка. Тај фајл није слика!',
			'no_user'			=> 'Непостојећи корисник'
		);
	}

	static private function LangProfileEN() {

		return $l = array(

			'no_user_data'		=> 'No information about the user!',
			'fill_username'		=> 'Please enter the username!',
			'us_leng_min'		=> 'The username must have more than 2 characters!',
			'us_leng_max'		=> 'The username must not have more than 20 characters!',
			'us_space'			=> 'The username must not contain a blank character!',
			'fill_pass'			=> 'Enter your password!',
			'pass_leng_min'		=> 'The password must have more than 2 characters!',
			'pass_leng_max'		=> 'The password must not have more than 20 characters!',
			'pass_space'		=> 'The password must not contain a blank character!',
			'fill_email'		=> 'Please enter a valid e-mail!',
			'fake_email'		=> 'Invalid e-mail!',
			'us_exist'			=> 'This username already exists in our database!',
			'email_exist'		=> 'This email already exists in our database!',
			'to_large'			=> 'Image is too big (max 1mb)!',
			'error_image'		=> 'Error. This file is not an image!',
			'no_user'			=> 'No existing user'
		);
	}

	static private function LangEditSR() {

		return $l = array(

			'to_large'			=> 'Слика је превелика (макс: 1мб)!',
			'image_success'		=> 'Успех! Додали сте слику на сервер. Њен линк је: ',
			'error_image'		=> 'Грешка. Тај фајл није слика!',
			'seo_exists'		=> 'Изаберите други СЕО линк, тај већ постоји!',
			'empty_fields'		=> 'Попуните поља!',
			'cat_exist'			=> 'То име категорије већ постоји. Изаберите друго!',
			'no_user'			=> 'Непостојећи корисник!',
			'enter_us'			=> 'Унеси корисничко име!',
			'usert_no_chang'	=> 'Тип корисника није промењен!',
			'mess_leng'			=> 'Поруке морају садржати више од 10 а мање од 190 карактера!',
			'delete_all_no'		=> 'Нема порука!',
			'delete_old_no'		=> 'Нема старих порука!'
		);
	}

	static private function LangEditEN() {

		return $l = array(

			'to_large'			=> 'Image is too big (max 1mb)!',
			'image_success'		=> 'Success! You added a picture to the server. Its link is: ',
			'error_image'		=> 'Error. This file is not an image!',
			'seo_exists'		=> 'Choose another SEO link, that already exists!',
			'empty_fields'		=> 'Fill the fields!',
			'cat_exist'			=> 'That category name already exists. Choose another!',
			'no_user'			=> 'No existing user!',
			'enter_us'			=> 'Please enter username!',
			'usert_no_chang'	=> 'User type has not changed!',
			'mess_leng'			=> 'Messages must contain more than 10 characters and less than 190 characters!',
			'delete_all_no'		=> 'No messages!',
			'delete_old_no'		=> 'No old messages!'
		);
	}
}	