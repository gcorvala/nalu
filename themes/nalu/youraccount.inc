<?php 
if ($auth->is_anonymous ()) {
?>
	<h3>Please login to manage your account</h3>
	<p>Don't have an account? <a href="?action=register">Register one!</a></p>
<?php
}
else {
	echo "<h3>Manage your account options</h3>"; 
?>

	<p>
		<h4>Change your nickname</h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="changenick"/>
			<label for="nick" class="required" accesskey="n">New nickname : </label>
				<input type="text" id="nick" name="nick" tabindex="1" value="" title="nick">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="2">
		</fieldset>
		</form>
	</p>
	<p>
		<h4>Change your password</h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="changepasswd"/>
			<label for="passwd" class="required" accesskey="p">New password : </label>
				<input type="text" id="passwd" name="passwd" tabindex="3" value="" title="passwd">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="4">
		</fieldset>
		</form>
		<!-- TODO demander 2 fois le pass et le vérifier, demander l'ancien pass et le vérifier. -->
	</p>
	<p>
		<h4>Change your city</h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="changecity"/>
			<label for="city" class="required" accesskey="c">New city : </label>
				<input type="text" id="city" name="city" tabindex="5" value="" title="city">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="6">
		</fieldset>
		</form>
	</p>
	<p>
		<h4>Change your Country</h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="changecountry"/>
			<label for="country" class="required" accesskey="o">New country : </label>
				<input type="text" id="country" name="country" tabindex="7" value="" title="country">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="8">
		</fieldset>
		</form>
	</p>
	<p>
		<h4>Change your avatar</h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="changeavatar"/>
			<label for="avatar" class="required" accesskey="a">New avatar : </label>
				<input type="text" id="avatar" name="avatar" tabindex="9" value="" title="avatar">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="10">
		</fieldset>
		</form>
	</p>
	<p>
		<h4>Change your biography</h4>
		<form action="." method="post" name="f">
		<fieldset>
			<input type="hidden" name="action" value="changebiography"/>
			<label for="biography" class="required" accesskey="b">New biography : </label>
				<input type="text" id="biography" name="biography" tabindex="11" value="" title="biography">
			<label for="submit"></label>
				<input type="submit" value="Send" id="submit" tabindex="12">
		</fieldset>
		</form>
	</p>


<?php
}
?>


