<?php 
if ($auth->is_anonymous ()) {
?>
	<h3>Please login to manage your friend list</h3>
	<p>Don't have an account? <a href="?action=register">Register one!</a></p>
<?php
}
else {
	echo "<h3>Manage your friend list</h3>"; 
?>

	<p>
		<h4>You are curently friend with :</h4>
		<ul>
<?php
		$friends = $user->get_friends ();
		foreach ($friends as $friend)
			echo "<li>" . $friend->get_nickname() . "</li>";
?>
		</ul>
	</p>
	<p>
		<h4>Add a friendship</h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="addfriend"/>
			<label for="friendname" class="required" accesskey="n">New friend mail address : </label>
				<input type="text" id="friendname" name="friendname" tabindex="1" value="" title="friendname">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="2">

		</fieldset>
		</form>
	</p>
	<p>
		<h4>Remove a friendship : </h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="deletefriend"/>
			<label for="friendname" class="required" accesskey="r">Friend to remove mail address : </label>
				<input type="text" id="friendname" name="friendname" tabindex="1" value="" title="friendname">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="2">

		</fieldset>
		</form>

	</p>
	
<?php
}
?>


