<form action="?action=register" method="post" name="f">
<fieldset>
<legend><h3>NaluRSS Registration</h3></legend>
<p><b>Bold</b> fields are required. <u>U</u>nderlined letters are accesskeys.</p>
	<label for="email" class="required" accesskey="e">Email : </label>
		<input type="text" id="email" name="email" tabindex="1" value="" title="email"><br>
	<label for="password" class="required" accesskey="p">Password : </label>
		<input type="password" id="password" name="password" tabindex="2" value="" title="password"><br>
		<small>Your password must be between 6 and 32 characters.</small>
	<label for="nickname" class="required" accesskey="n">Nickname : </label>
		<input type="text" id="nickname" name="nickname" tabindex="3" value="" title="nickname"><br>
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
