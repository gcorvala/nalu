<?php 
if ($auth->is_anonymous ()) {
?>
	<h3>Please login to access this page</h3>
	<p>Don't have an account? <a href="?action=register">Register one!</a></p>
<?php
}
else {
	$feed = new Feed($_GET['feed']);
	$item = new Item($_GET['item']);
	echo "<h3>Share this item with your friends</h3>";
	echo "If you want to add a note with the article, please write it below. If you don't just click submit.";
?>
	<p>
		<form action="." method="get" name="f">
		<fieldset>
			<input type="hidden" name="action" value="add_share"/>
<?php
			echo "<input type=\"hidden\" name=\"feed\" value=\"" . $feed->get_url() . "\"/>";
			echo "<input type=\"hidden\" name=\"item\" value=\"" . $item->get_url() . "\"/>";
?>
			<label for="feed" class="required" accesskey="c"></label>
				<textarea name="comment" cols="50" rows="10" wrap="on"></textarea>
			<label for="submit"></label>
				<input type="submit" value="Share" id="submit" tabindex="2">

		</fieldset>
		</form>
	</p>
	
<?php
}
?>
