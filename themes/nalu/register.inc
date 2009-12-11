<form action="." method="post" name="f">
<fieldset>
<legend><h3>NaluRSS Registration</h3></legend>
<p><b>Bold</b> fields are required. <u>U</u>nderlined letters are accesskeys.</p>
	<input type="hidden" name="action" value="register"/>
	<label for="login" class="required" accesskey="l">Login : </label>
		<input type="text" id="login" name="login" tabindex="1" value="" title="login"><br>
	<label for="passwd" class="required" accesskey="p">Password : </label>
		<input type="password" id="passwd" name="passwd" tabindex="2" value="" title="passwd"><br>
		<small>Your password must be between 6 and 32 characters.</small>
	<label for="mail" class="required" accesskey="m">Email address : </label>
		<input type="text" id="mail" name="mail" tabindex="3" value="" title="mail"><br>
		<small>Don't worry, your mail address won't be given away.</small>
	<label for="city" accesskey="c">City : </label>
		<input type="text" id="city" name="city" tabindex="4" value="" title="city"><br>
	<label for="country" accesskey="o">Country : </label>
		<input type="text" id="country" name="country" tabindex="5" value="" title="country"><br>
	<label for="avatar" accesskey="a">Avatar : </label>
		<input type="text" id="avatar" name="avatar" tabindex="6" title="avatar"><br>
	<label for="biography" accesskey="b">Biography : </label>
		<input type="text" id="biography" name="biography" tabindex="7" title="biography"><br>
</fieldset>
<label for="submit"></label>
	<input type="submit" value="Send" id="submit" tabindex="8"> <INPUT type="reset" id="reset" tabindex="9">
</form>
