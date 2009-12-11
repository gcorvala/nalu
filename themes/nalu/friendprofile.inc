<?php 
if ($auth->is_anonymous ()) {
?>
	<h3>Please login to access this profile</h3>
	<p>Don't have an account? <a href="?action=register">Register one!</a></p>
<?php
}
else {
	$friend = new User($_GET['friendemail']);
	echo "<h3> " . $friend->get_nickname() . "</h3>";

	echo "<ul>";
		echo "<li> Mail address : " . $friend->get_email() . "</li>";
		echo "<li> City : " . $friend->get_city() . "</li>";
		echo "<li> Country : " . $friend->get_country() . "</li>";
		echo "<li> Biography : " . $friend->get_biography() . "</li>";
	echo "</ul>";
	echo "<a href=?action=feedpage&feedurl=" . $friend->get_own_feed()->get_url() . "> View " . $friend->get_nickname() . " feed </a>";
}
?>

