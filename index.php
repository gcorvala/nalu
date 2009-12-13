<?php
require_once ("core/config.php");
require_once ("core/auth.php");
require_once ("core/feed.php");
require_once ("core/item.php");
require_once ("core/user.php");

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
			case "login":
				$action = "home";
				break;
			case "logout":
				$auth->disconnect ();
				$action = "home";
				break;
			case "read":
				$item = new Item ($_GET['item']);
				//$user->read ($item);
				header ('Location: ' . $item->get_url ());
				break;
			// unread?
			case "add_subscription":
				$feed = new Feed ($_GET['feed']);
				$user->subscribe_to_feed ($feed);
				break;
			case "remove_unsubscription":
				$feed = new Feed ($_GET['feed']);
				$user->unsubscribe_to_feed ($feed);
				break;
			case "add_friend":
				$friend = new User ($_GET['friend']);
				$user->add_friend ($friend);
				break;
			case "remove_friend":
				$friend = new User ($_GET['friend']);
				$user->remove_friend ($friend);
				break;
			case "add_comment":
				$feed = new Feed ($_GET['feed']);
				$item = new Item ($_GET['item']);
				$comment = $_GET['comment'];
				$user->add_comment ($feed, $item, $comment);
				break;
			case "remove_comment":
				//$user->remove_comment ()
				break;
			case "add_share":
				$feed = new Feed ($_GET['feed']);
				$item = new Item ($_GET['item']);
				$note = $_GET['note'];
				$user->share ($feed, $item, $note);
				break;
			case "remove_share":
				//$user->remove_share ()
				break;
		}
	}
	include ("themes/" . $config->get_site_theme () . "/page.inc");
}
catch (Exception $e) {
	echo "Exception catched : ". $e->getMessage (). "<br>";
}
?>