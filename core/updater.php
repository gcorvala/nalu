<?php
require_once ("core/data.php");
require_once ("core/feed.php");

class Updater {
	public function __construct () {
		$data = Data::create ();
		$req = "SELECT URL FROM Feeds";
		$result = $data->request ($req);
		while ($line = mysql_fetch_array ($result)) {
			$feed = new Feed ($line['URL']);
			$feed->update ();
			echo "updated : " . $feed->get_url () . "<br>";
		}
	}
}
?>