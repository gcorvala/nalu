<?php

require_once ("rssfeed.php");
require_once ("rssitem.php");
require_once ("importer.php");
require_once ("user.php");

try {
	$mysql_link = mysql_connect ("localhost:8889", "root", "root")
		or die ("Mysql connection failed! : " . mysql_error ());
	mysql_select_db ("db_projet", $mysql_link)
		or die ("Mysql database selection failed! : " . mysql_error ());
	
	echo "<tt>";
	$feed = new RSSFeed ("http://xkcd.com/rss.xml");
	$items = $feed->get_items ();
	$feed = new RSSFeed ("lalibre.xml");
	//$feed = new RSSFeed ("http://www.ulb.ac.be/actulb/rss/lastnews.rss");
	$feed = new RSSFeed ("ulb.xml");
	//$feed = new RSSFeed ("user://gcorvala");

	
	$user = new User ();
	if (isset ($_GET['email']) and isset ($_GET['password'])) {
		$user->login ($_GET['email'], $_GET['password']);
		$user->get_friends ();
	}
	//else
		//$user->create ("gcorvala", "abcd", "gab", "bruxelles", "belgique", "gab.png");
}
catch (Exception $e) {
	echo "Exception catched : ". $e->getMessage (). "<br>";
}

//$importer = new importer ();
//$importer->from_xml ("bdd_projet_0910_data.xml");
//mysql_close ();

?>