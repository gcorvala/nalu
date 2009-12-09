<?php
require_once ("core/config.php");
require_once ("core/auth.php");
require_once ("core/rssfeed.php");
require_once ("core/rssitem.php");
require_once ("core/user.php");

try {
	$auth = new Auth ();
	$config = new Config ();
	//$page = file_get_contents ("themes/" . $config->get_site_theme () . "/page.inc");
	//$page = str_replace ("@SITE_NAME@", $config->get_site_name (), $page);
	if ($_GET['action'] == "logout")
		$auth->disconnect ();
	if ($auth->is_anonymous ()) {
		//$register = file_get_contents ("themes/" . $config->get_site_theme () . "/register.inc");
		//$page = str_replace ("@PAGE_CONTENT@", $register, $page);
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
		if ($_GET['action'] == "read") {
			$item = new RSSItem ($_GET['item']);
			$user->read ($item);
			header ('Location: ' . $item->get_url ());
		}
		include ("themes/" . $config->get_site_theme () . "/page.inc");
		/*echo $user->get_email () . "<br>";
		echo $user->get_nickname () . "<br>";
		echo $user->get_city () . "<br>";
		echo $user->get_country () . "<br>";
		echo $user->get_avatar () . "<br>";
		echo $user->get_biography () . "<br>";
		echo $user->get_subscribe_date () . "<br>";
		echo "<hr>";*/

/*		echo "Feeds :<br>";
		$feeds = $user->get_feeds ();
		foreach ($feeds as $feed) {
			echo "<div id=\"gallery\">+--" . $feed->get_url () . "<br>";
			$feed->update_items ();
			$items = $feed->get_items ();
			echo "<table width=\"100%\">";
			foreach ($items as $item) {
				echo "<tr>";
				echo "<td width=10><input type=\"checkbox\"></td>";
				echo "<td><b><a href=\"?action=read&item=" . $item->get_url () . "\" target=\"blank\">" . $item->get_title () . "</a></b></td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		echo "<hr>";*/

		/*echo "Friends :<br>";
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
			switch ($_GET['action']) {
				case "addrss":
					$user->subscribe_to_feed ($_GET['url']);
					break;
			}
		}*/
	}
}
catch (Exception $e) {
	echo "Exception catched : ". $e->getMessage (). "<br>";
}
?>