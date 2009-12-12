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
	echo "<h3>Welcome $nickname </h3>"; 
?>
	<ul>
		<li><a href="?action=youraccount">Manage your account</a></li>
		<li><a href="?action=managefeeds">Manage your feeds</a></li>
		<li><a href="?action=managefriends">Manage your friends</a></li>
		<?php echo "<li><a href=?action=feedpage&feedurl=" . $user->get_own_feed()->get_url() . ">View your own feed</a></li>"?>
	</ul>
	
<?php
}
?>
