<?php 
if ($auth->is_anonymous ()) {
?>
	<h3>Please login to manage your feeds</h3>
	<p>Don't have an account? <a href="?action=register">Register one!</a></p>
<?php
}
else {
	echo "<h3>Manage your feeds subscriptions</h3>"; 
?>

	<p>
		<h4>You are curently following :</h4>
		<ul>
<?php
		$feeds = $user->get_feeds ();
		foreach ($feeds as $feed)
			echo "<li><a class=\"feed-link\" href=\"" . $feed->get_url () ."\">" . $feed->get_name () . "</a></li>";
?>
		</ul>
	</p>
	<p>
		<h4>Add a feed to follow : </h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="subscribe"/>
			<label for="feedurl" class="required" accesskey="n">New feed url : </label>
				<input type="text" id="feedurl" name="feedurl" tabindex="1" value="" title="feedurl">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="2">

		</fieldset>
		</form>
	</p>
	<p>
		<h4>Stop following a feed : </h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="unsubscribe"/>
			<label for="feedurl" class="required" accesskey="r">Feed to remove url : </label>
				<input type="text" id="feedurl" name="feedurl" tabindex="1" value="" title="feedurl">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="2">

		</fieldset>
		</form>

	</p>
	
<?php
}
?>

