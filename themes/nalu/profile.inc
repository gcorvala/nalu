<?php 
if ($auth->is_anonymous ()) {
?>
	<h3>Please login to access your profile</h3>
	<p>Don't have an account? <a href="?action=register">Register one!</a></p>
<?php
}
else {
	$user = $auth->get_user();
	$nickname = $user->get_nickname(); 
	echo "<legend><h3>Welcome $nickname </h3></legend>"; 
?>

	<p>
		<h4>You are curently following :</h4>
<?php
		$feeds = $user->get_feeds ();
		echo "bite";
		foreach ($feeds as $feed)
			echo "<li><a class=\"feed-link\" href=\"" . $feed->get_url () ."\">" . $feed->get_name () . "</a></li>";
?>
	</p>
	<p>
		<h4>Add a feed to follow : </h4>
		TODO
	</p>
	<p>
		<h4>Stop following a feed : </h4>
		TODO
	</p>
	
<?php
}
?>
