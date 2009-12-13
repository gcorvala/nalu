<?php
require_once ("core/config.php");
require_once ("core/auth.php");
require_once ("core/feed.php");
require_once ("core/item.php");
require_once ("core/user.php");
require_once ("core/updater.php");

try {
	$auth = new Auth ();
	$config = new Config ();
	$action = isset ($_GET['action']) ? $_GET['action'] : "home";
	if ($auth->is_anonymous ()) {
		if ($action == "register" && isset ($_POST['email'])) {
			extract ($_POST, EXTR_PREFIX_ALL, "reg");
			$user = new User ($reg_email,
							  $reg_password,
							  $reg_nickname,
							  $reg_city,
							  $reg_country,
							  $reg_avatar,
							  $reg_biography);
			$action = "login";
		}
	}
	else {
		$user = $auth->get_user ();
		switch ($action) {
			case "add_comment":
				$feed = new Feed ($_GET['feed']);
				$item = new Item ($_GET['item']);
				$comment = $_GET['comment'];
				$user->add_comment ($feed, $item, $comment);
				break;
			case "add_friend":
				$friend = new User ($_GET['friend']);
				$user->add_friend ($friend);
				break;
			case "add_share":
				$feed = new Feed ($_GET['feed']);
				$item = new Item ($_GET['item']);
				$note = $_GET['note'];
				$user->share ($feed, $item, $note);
				break;
			case "add_subscription":
				$feed = new Feed ($_GET['feed']);
				$user->subscribe_to_feed ($feed);
				break;
			case "login":
				$action = "home";
				break;
			case "logout":
				$auth->disconnect ();
				$action = "home";
				break;
			case "add_read":
				$item = new Item ($_GET['item']);
				$user->read ($item);
				break;
			case "read":
				$feed = new Feed ($_GET['feed']);
				$item = new Item ($_GET['item']);
				$user->set_item_readed ($feed, $item);
				header ('Location: ' . $item->get_url ());
				break;
			case "remove_read":
				$item = new Item ($_GET['item']);
				$user->remove_read ($item);
				break;
			case "remove_comment":
				$user->remove_comment ();
				break;
			case "remove_friend":
				$friend = new User ($_GET['friend']);
				$user->remove_friend ($friend);
				break;
			case "remove_share":
				$user->remove_share ();
				break;
			case "remove_subscription":
				$feed = new Feed ($_GET['feed']);
				$user->unsubscribe_to_feed ($feed);
				break;
			case "remove_subscriptions":
				$feeds = $_GET['feeds'];
				foreach ($feeds as $feed) {
					$feed = new Feed ($feed);
					$user->unsubscribe_to_feed ($feed);
				}
				break;
			case "set_nickname":
				$nickname = $_GET['nickname'];
				$user->set_nickname ($nickname);
				break;
			case "set_password":
				$password = $_GET['password'];
				$user->set_password ($password);
				break;
			case "set_city":
				$city = $_GET['city'];
				$user->set_city ($city);
				break;
			case "set_country":
				$country = $_GET['country'];
				$user->set_country ($country);
				break;
			case "set_avatar":
				$avatar = $_GET['avatar'];
				$user->set_avatar ($avatar);
				break;
			case "set_biography":
				$biography = $_GET['biography'];
				$user->set_biography ($biography);
				break;
			case "update":
				$updater = new Updater ();
				break;
		}
	}
	include ("themes/" . $config->get_site_theme () . "/page.inc");
}
catch (Exception $e) {
	echo "Exception catched : ". $e->getMessage (). "<br>";
}
?>