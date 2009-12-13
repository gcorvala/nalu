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
	if ($action == "logout") {
		$auth->disconnect ();
		$action = "home";
	}
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
		if ($action == "login")
			$action == "home";
		if ($action == "read") {
			$item = new Item ($_GET['item']);
			//$user->read ($item);
			header ('Location: ' . $item->get_url ());
		}
	}
	include ("themes/" . $config->get_site_theme () . "/page.inc");
}
catch (Exception $e) {
	echo "Exception catched : ". $e->getMessage (). "<br>";
}
?>