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
		<form action="." method="get" name="f">
		<input type="hidden" name="action" value="remove_subscriptions">
		<ul>
<?php
		$feeds = $user->get_feeds ();
		foreach ($feeds as $feed)
			echo "<input type=\"checkbox\" name=\"feeds[]\" value=\"" . $feed->get_url () ."\"> " . $feed->get_name () . "<br>";
?>
		</ul>
		<input type="submit" value="Delete">
		</form>
	</p>
	<p>
		<h4>Add a feed to follow : </h4>
		<form action="." method="get" name="f">
		<fieldset>
			<input type="hidden" name="action" value="add_subscription"/>
			<label for="feed" class="required" accesskey="n">New feed url : </label>
				<input type="text" id="feed" name="feed" tabindex="1" value="" title="feed">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="2">

		</fieldset>
		</form>
	</p>	
<?php
}
?>

