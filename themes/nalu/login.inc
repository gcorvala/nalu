<!--<h3>Please login :</h3>
<form method="post" action=".">
	<input type="hidden" name="action" value="login"/>
	<p>
		<label for="email">Email</label> : <input type="text" name="email" id="email"/>
		<br />
		<label for="password">Password</label> : <input type="password" name="password" id="password"/>
	</p>
	<p>
		<input type="submit" /> <input type="reset" />
	</p>
</form>
-->

<form method="post" action=".">
<fieldset>
<legend><h3>Log into NaluRSS</h3></legend>
	<input type="hidden" name="action" value="login"/>
	<label for="email" class="required" accesskey="m">Mail address : </label>
		<input type="text" id="email" name="email" tabindex="1" value="" title="email"><br>
	<label for="password" class="required" accesskey="p">Password : </label>
		<input type="password" id="password" name="password" tabindex="2" value="" title="password"><br>
</fieldset>
<label for="submit"></label>
	<input type="submit" /> <INPUT type="reset" id="reset" tabindex="4" />
</form>



<p>Don't have an account? Register <a href="?action=register">here</a>.</p>
