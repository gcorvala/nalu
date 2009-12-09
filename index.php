<?php
require_once ("core/config.php");
require_once ("core/data.php");
require_once ("core/auth.php");

try {
	$auth = new Auth ();
	if ($_GET['action'] == "disconnect")
		$auth->disconnect ();
	$config = new Config ();
	$data = Data::create ();
	if ($auth->is_anonymous ()) {
		echo "<center>Not connected!</center>";
		echo "<div><form method=\"post\" action=\".\">";
		echo "email : <input type\"text\" name=\"email\"></br>";
		echo "pass : <input type=\"password\" name=\"password\" align=\"right\"></br>";
		echo "<input type=\"submit\">";
		echo "</form></div>";
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
		echo "<a href=\"?action=disconnect\">Disconnect</a><br>";
	}

	echo "<a href=\"index.php\">link</a><br>";
	echo "end<br>";
}
catch (Exception $e) {
	echo "Exception catched : ". $e->getMessage (). "<br>";
}
?>