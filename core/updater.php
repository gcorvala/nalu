<?php
require_once ("core/data.php");
require_once ("core/feed.php");

class Updater {
	public function __construct () {
		$data = Data::create ();
		$req = "SELECT URL FROM Feeds";
		$result = $data->request ($req);
		$rapport = array ();
		while ($line = mysql_fetch_array ($result)) {
			try {
				$feed = new Feed ($line['URL']);
				$feed->update ();
				$rapport .= "updated success : " . $feed->get_url () . "<br>";
			}
			catch (Exception $e) {
				$rapport .= "update fail ! : " . $e->getMessage () . "<br>";
			}
		}
		return $rapport;
	}
}
?>