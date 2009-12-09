<?php
require_once ("core/config.php");
require_once ("core/data.php");
require_once ("core/auth.php");
require_once ("core/rssfeed.php");

try {
	$auth = new Auth ();
	if ($_GET['action'] == "disconnect")
		$auth->disconnect ();
	$config = new Config ();
	$data = Data::create ();
	if ($auth->is_anonymous ()) {
		echo "<center>Not connected!</center>";
		echo "<div><form method=\"post\" action=\".\">";
		echo "email : <input type=\"text\" name=\"email\"></br>";
		echo "pass : <input type=\"password\" name=\"password\" align=\"right\"></br>";
		echo "<input type=\"submit\">";
		echo "</form></div>";
		echo "<hr>";
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

		$friends = $user->get_friends ();
		foreach ($friends as $friend) {
			echo $friend . "<br>";
		}
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