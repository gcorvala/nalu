<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login to NaluRSS</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<div id="wrap">
	<?php include('header.php'); ?>

	<?php include('topmenu.php');?>
	
	<div id="content">
		<!-- left hand main content -->
		<div id="page">
				<h3>Please login :</h3>
				<form method="post" action="../index.php">
					<p>
						<label for="pseudo">Login</label> : <input type="text" name="pseudo" id="pseudo"/>
						<br />
						<label for="passwd">Password</label> : <input type="password" name="passwd" id="passwd"/>
					</p>
				</form>
				<p>
					<input type="submit" /> <input type="reset" />
				</p>
				
				<p>Don't have an account? Register <a href="register.php">here</a>.</p>

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
