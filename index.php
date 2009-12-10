<?php
require_once ("core/config.php");
require_once ("core/auth.php");
require_once ("core/rssfeed.php");
require_once ("core/rssitem.php");
require_once ("core/user.php");

try {
	$auth = new Auth ();
	$config = new Config ();
	if (!isset ($_GET['action']))
		$action = "home";
	else
		$action = $_GET['action'];
	if ($action == "logout")
		$auth->disconnect ();
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
		if ($action == "read") {
			$item = new RSSItem ($_GET['item']);
			$user->read ($item);
			header ('Location: ' . $item->get_url ());
		}
	}
	include ("themes/" . $config->get_site_theme () . "/page.inc");
}
catch (Exception $e) {
	echo "Exception catched : ". $e->getMessage (). "<br>";
}
?>