<?php
require_once ("core/config.php");
require_once ("core/data.php");
require_once ("core/auth.php");
require_once ("core/rssfeed.php");
require_once ("core/rssitem.php");
require_once ("core/user.php");

try {
	$auth = new Auth ();
	if ($_GET['action'] == "disconnect")
		$auth->disconnect ();
	$config = new Config ();
	$data = Data::create ();
	if ($auth->is_anonymous ()) {
		echo "<div><form method=\"post\" action=\".\">";
		echo "Connection :<br>";
		echo "<input type=\"hidden\" name=\"action\" value=\"login\">";
		echo "email : <input type=\"text\" name=\"email\"></br>";
		echo "pass : <input type=\"password\" name=\"password\" align=\"right\"></br>";
		echo "<input type=\"submit\">";
		echo "</form></div>";
		echo "<hr>";
		echo "<div><form method=\"post\" action=\".\">";
		echo "Register :<br>";
		echo "<input type=\"hidden\" name=\"action\" value=\"register\">";
		echo "email : <input type=\"text\" name=\"email\"></br>";
		echo "password : <input type=\"password\" name=\"password\"></br>";
		echo "nickname : <input type=\"text\" name=\"nickname\"></br>";
		echo "city : <input type=\"text\" name=\"city\"></br>";
		echo "country : <input type=\"text\" name=\"country\"></br>";
		echo "avatar : <input type=\"text\" name=\"avatar\"></br>";
		echo "biography : <input type=\"text\" name=\"biography\"></br>";
		echo "<input type=\"submit\">";
		echo "</form></div>";
		echo "<hr>";
		if (isset ($_POST['action'])) {
			switch ($_POST['action']) {
				case "register":
					extract ($_POST, EXTR_PREFIX_ALL, "reg");
					$user = new User ($reg_email,
									  $reg_password,
									  $reg_nickname,
									  $reg_city,
									  $reg_country,
									  $reg_avatar,
									  $reg_biography);
					echo "user added : $reg_email<br>";
					break;
			}
		}
	}
	else {
		$user = $auth->get_user ();
		echo $user->get_email () . "<br>";
		echo $user->get_nickname () . "<br>";
		echo $user->get_city () . "<br>";
		echo $user->get_country () . "<br>";
		echo $user->get_avatar () . "<br>";
		echo $user->get_biography () . "<br>";
		echo $user->get_subscribe_date () . "<br>";
		echo "<hr>";

		echo "Feeds :<br>";
		$feeds = $user->get_feeds ();
		foreach ($feeds as $feed) {
			echo $feed->get_url () . "<br>";
			//$feed->update_items ();
			$items = $feed->get_items ();
			foreach ($items as $item) {
				echo "lol";
				echo $item->get_title () . "<br>";
			}
		}
		echo "<hr>";

		echo "Friends :<br>";
		$friends = $user->get_friends ();
		foreach ($friends as $friend)
			echo $friend . "<br>";
		echo "<hr>";

		echo "<center>Subscribe to a feed!</center>";
		echo "<div><form method=\"get\" action=\".\">";
		echo "<input type=\"hidden\" name=\"action\" value=\"addrss\">";
		echo "url : <input type=\"text\" name=\"url\"></br>";
		echo "<input type=\"submit\">";
		echo "</form></div>";

		echo "<hr>";
		echo "<a href=\"?action=disconnect\">Disconnect</a><br>";
		if (isset ($_GET['action'])) {
			$action = $_GET['action'];
			switch ($action) {
				case "addrss":
					$user->subscribe_to_feed ($_GET['url']);
					break;
			}
		}
	}

	echo "<a href=\"index.php\">link</a><br>";
	echo "end<br>";
}
catch (Exception $e) {
	echo "Exception catched : ". $e->getMessage (). "<br>";
}
?>