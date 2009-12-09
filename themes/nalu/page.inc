<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Welcome to <? echo $config->get_site_name (); ?></title>
		<link rel="stylesheet" href="themes/nalu/css/styles.css" type="text/css" />
	</head>
	<body>
		<div id="wrap">
			<div id="header">
				<div id="header-text">
					<!-- page header - use <span></span> to colour text white, default color orange -->
					<h1><a href="#">Nalu<span>RSS</span></a></h1>

					<!-- sub title here -->
					<h2>A refreshing rss reader.</h2>

					<div class="clear"></div>
				</div>
			</div>
				
			<div id="navigation">
				<div id="innernav">
					<ul>
						<!-- top navigation  -->
						<!-- add class navleft to first item and navright to last item as shown -->
						<li class="navleft"><a href=".">Home</a></li>
<?
if ($auth->is_anonymous ())
	echo "<li><a href=\"?action=login\">Login</a></li>";
else
	echo "<li><a href=\"?action=logout\">Logout</a></li>";
?>
						<li><a href="?action=help">Help</a></li>
<?
if ($auth->is_anonymous ()) {
?>
						<li><a href="?action=register">Register</a></li>
<?
}
?>
						<li><a href="?action=about">About</a></li>
						<li><a href="?action=profile">My profile</a></li>
						<li class="navright"><a href="#">Contact</a></li>
					</ul>
				</div>
			</div>

				<div id="content">
					<!-- left hand main content -->
					<div id="page">
<?
						echo $user->get_email () . "<br>";
						echo $user->get_nickname () . "<br>";
						echo $user->get_city () . "<br>";
						echo $user->get_country () . "<br>";
						echo $user->get_avatar () . "<br>";
						echo $user->get_biography () . "<br>";
						echo $user->get_subscribe_date () . "<br>";
?>
					</div>
					<!-- end left hand main content -->

					<!-- start sidebar -->
					<div id="sidebar">

						<!-- sidebar h3: wrap text in <span></span> tags as shown -->
						<h3><span>feeds</span></h3>
						<ul>
<?
$feeds = $user->get_feeds ();
foreach ($feeds as $feed)
	echo "<li><a class=\"feed-link\" href=\"" . $feed->get_url () ."\">" . $feed->get_name () . "</a></li>";
?>
						</ul>


						<!-- <p class="newsitem">
							<span>18 April 2009</span><br />
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in massa. Curabitur id nisl. Duis tempus lorem nec justo. In hac habitasse platea dictumst.
							<a class="read-more-link" href="#">Continue reading</a>
						</p>

						<p class="newsitem">
							<span>14 April 2009</span><br />
							Duis dolor ante, pharetra vitae, aliquam consectetur, ultricies sed, sem. Maecenas consequat magna ac ligula. Phasellus tincidunt odio non magna. Nullam tincidunt convallis lorem.
							<a class="read-more-link" href="#">Continue reading</a>
						</p>
						<p class="newsistem">
							<span><a class="read-more-link" href="http://cerkinfo.be">cerkinfo.be</a></span> <br />
							<span><a class="read-more-link" href="http://cerkinfo.be">cerkinfo.be</a></span> <br />
							<span><a class="read-more-link" href="http://cerkinfo.be">cerkinfo.be</a></span> <br />
							<span><a class="read-more-link" href="http://cerkinfo.be">cerkinfo.be</a></span> <br />
							<span><a href="http://cerkinfo.be">cerkinfo.be</a></span> <br />

						</p>
						-->

						<h3><span>friends</span></h3>
						<ul>
<?
$friends = $user->get_friends ();
foreach ($friends as $friend)
	echo "<li>" . $friend->get_nickname () . "</li>";
?>
						</ul>

						<!-- <ul>
						    <li><a href="http://www.spyka.net" title="spyka Webmaster resources">spyka webmaster</a></li>
							<li><a href="http://www.justfreetemplates.com" title="free web templates">Free web templates</a></li>
							<li><a href="http://www.spyka.net/forums" title="webmaster forums">Webmaster forums</a></li>
							<li><a href="http://www.profileartist.net" title="premium templates">Premium templates</a></li>
							<li><a href="http://www.awesomestyles.com" title="free phpbb3 themes">phpBB3 styles</a></li>
						</ul>
						-->

					</div>

					<!-- end sidebar -->

					<div class="clear"></div>		
				</div>
				<div class="footer">
							<p class="left">&copy; 2009 Contzen Laurent and Corvalan Gabriel, ULB.  Design by <a href="http://www.spyka.net">spyka Webmaster</a> | <a href="http://www.justfreetemplates.com">Free Web Templates</a></p>
							<p class="right">
								<a href="http://validator.w3.org/check/referer" title="valid XHTML">XHTML</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer" title="valid CSS">CSS</a>
							</p>
							<div class="clear"></div>					
						</div>
			</div>
		</div>
</html>