<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Welcome to <?php echo $config->get_site_name (); ?></title>
		<link rel="stylesheet" href="<?php echo $config->get_site_theme_folder (); ?>/css/styles.css" type="text/css" />
	</head>
	<body>
		<div id="wrap">
			<div id="header">
				<div id="header-text">
					<h1><a href="?action=home">Nalu<span>RSS</span></a></h1>
					<h2>A refreshing rss reader.</h2>
					<div class="clear"></div>
				</div>
			</div>
			<div id="navigation">
				<div id="innernav">
					<ul>
						<li class="navleft"><a href=".">Home</a></li>
<?php
if ($auth->is_anonymous ())
	echo "<li><a href=\"?action=login\">Login</a></li>";
else
	echo "<li><a href=\"?action=logout\">Logout</a></li>";
?>
						<li><a href="?action=help">Help</a></li>
<?php
if ($auth->is_anonymous ()) {
?>
						<li><a href="?action=register">Register</a></li>
<?php
}
?>
						<li><a href="?action=about">About</a></li>
						<li><a href="?action=profile">My profile</a></li>
						<li class="navright"><a href="?action=contact">Contact</a></li>
					</ul>
				</div>
			</div>
			<div id="content">
				<div id="page">
<?php
include_once ($config->get_site_theme_folder () . "/" . $action . ".inc");
?>
				</div>
				<div id="sidebar">
					<h3><span>feeds</span></h3>
					<ul>
<?php
if (!$auth->is_anonymous ()) {
	$feeds = $user->get_feeds ();
	foreach ($feeds as $feed)
//		echo "<li><a class=\"feed-link\" href=\"" . $feed->get_url () ."\">" . $feed->get_name () . "</a></li>";
		echo "<li><a href=?action=feedpage&feedurl=" . $feed->get_url() . ">" . $feed->get_name() . "</a> - <a class=\"comment-link\" href=?action=fullfeedpage&feedurl=" . $feed->get_url() . ">View full</a></li>";
}
else {
	echo "Please login to see your feeds.";
}
?>
					</ul>
					<h3><span>friends</span></h3>
					<ul>
<?php
if (!$auth->is_anonymous ()) {
	$friends = $user->get_friends ();
	foreach ($friends as $friend)
		echo "<li><a href=?action=friendprofile&friendemail=" . $friend->get_email() . ">" . $friend->get_nickname () . "</a> - <a class=\"comment-link\"href=?action=feedpage&feedurl=" . $friend->get_own_feed()->get_url() . ">View feed</a></li>";
}
else {
	echo "Please login to see your friends.";
}
?>
					</ul>
				</div>
				<div class="clear"></div>		
			</div>
			<div class="footer">
				<p class="left">&copy; 2009 Contzen Laurent and Corvalan Gabriel, ULB.  Design by <a href="http://www.spyka.net">spyka Webmaster</a> | <a href="http://www.justfreetemplates.com">Free Web Templates</a></p>
				<p class="right"><a href="http://validator.w3.org/check/referer" title="valid XHTML">XHTML</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer" title="valid CSS">CSS</a></p>
				<div class="clear"></div>					
			</div>
		</div>
	</body>
</html>
