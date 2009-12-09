<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Register to NaluRSS</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<div id="wrap">
	<?php include('header.php'); ?>

	<?php include('topmenu.php');?>
	
	<div id="content">
		<!-- left hand main content -->
		<div id="page">
				<!--
				<h3>NaluRSS Registration</h3>
				
				
				<form method="post" action="../index.php">
					<p><p><b>Bold</b> fields are required. <u>U</u>nderlined letters are accesskeys.</p>
						<label for="pseudo">Pseudo</label> : <input type="text" name="pseudo" id="pseudo"/> <br />
						<label for="passwd">Password</label> : <input type="password" name="passwd" id="passwd"/> <br />
						<label for="email">Email address</label> : <input type="text" name="email" id="email"/> <br />
						<label for="city">City</label> : <input type="text" name="city" id="city"/> <br />
						<label for="coutry">Country</label> : <input type="text" name="country" id="coutry"/> <br />
						<label for="avatar">Avatar</label> : <input type="text" name="avatar" id="avatar"/> <br />
						<label for="biography">Biogaphy</label> : <input type="text" name="biography" id="biography"/>
					</p>
				</form>
				<p>
					<input type="submit" /> <input type="reset" />
				</p>
				-->
								
				<form action="#" method="post" name="f">
				<fieldset>
				<legend><h3>NaluRSS Registration</h3></legend>
				<p><b>Bold</b> fields are required. <u>U</u>nderlined letters are accesskeys.</p>
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
				</fieldset>
				</form>
								
				


		</div>
		<!-- end left hand main content -->
		
		<!-- start sidebar -->
		<?php include('leftpanel.php');?>		
		<!-- end sidebar -->
		
		<div class="clear"></div>		
	</div>
		<!-- start footer -->
		<?php include('footer.php'); ?>
		<!-- end footer -->
</div>
</body>
</html>

