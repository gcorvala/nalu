<?php
require_once ("core/config.php");
require_once ("core/rssfeed.php");
require_once ("core/rssitem.php");
require_once ("core/user.php");

class Importer {
	public function __construct ($xml) {
		$doc = new DOMDocument ();
		$xml_content = file_get_contents ($xml);
		$doc->loadXML ($xml_content);
		$users = $doc->getElementsByTagName ("user");
		$this->parse_users ($users);
		$friends = $doc->getElementsByTagName ("friend");
		$this->parse_friends ($friends);
		$subscriptions = $doc->getElementsByTagName ("subscription");
		$this->parse_subscriptions ($subscriptions);
		$reads = $doc->getElementsByTagName ("read");
		$this->parse_reads ($reads);
		/*$comments = $doc->getElementsByTagName ("comment");
		$this->parse_comments ($comments);
		$shares = $doc->getElementsByTagName ("share");
		$this->parse_shares ($shares);
		*/
	}

	private function parse_users ($users) {
		foreach ($users as $user) {
			foreach ($user->childNodes as $child) {
 				switch ($child->nodeName) {
					case "email":
					case "password":
					case "nickname":
					case "city":
					case "country":
					case "avatar":
					case "biography":
						$varname = $child->nodeName;
						$$varname = $child->nodeValue;
						break;
					case "subscribeDate":
						$datetime = new DateTime ($child->nodeValue); 
						$subscribeDate = $datetime->format ("c");
						break;
				}
			}
			try {
				$user = new User ($email, $password, $nickname, $city, $country, $avatar, $biography, $subscribeDate);
			}
			catch (Exception $e) {
				echo "PARSE_USERS Exception catched : ". $e->getMessage (). "<br>";
			}
		}
	}

	private function parse_friends ($friends) {
		foreach ($friends as $friend) {
			$email = array ();
			foreach ($friend->childNodes as $child) {
				switch ($child->nodeName) {
					case "email":
						$email[] = $child->nodeValue;
						break;
					case "date":
						$datetime = new DateTime ($child->nodeValue); 
						$date = $datetime->format ("c");
						break;
					case "accepted":
						$accepted = $child->nodeValue;
						break;
				}
			}
			try {
				$user = new User ($email[0]);
				$user->add_friend ($email[1]);
			}
			catch (Exception $e) {
				echo "PARSE_FRIENDS Exception catched : ". $e->getMessage (). "<br>";
			}
		}
	}

	private function parse_reads ($reads) {
		foreach ($reads as $read) {
			foreach ($read->childNodes as $child) {
				switch ($child->nodeName) {
					case "email":
					case "item":
					case "feed":
						$varname = $child->nodeName;
						$$varname = $child->nodeValue;
						break;
					case "date":
						$datetime = new DateTime ($child->nodeValue); 
						$date = $datetime->format ("c");
						break;
				}
			}
			try {
				$user = new User ($email);
				$user->set_item_readed ($item, $date);
			}
			catch (Exception $e) {
				echo "PARSE_READS Exception catched : ". $e->getMessage (). "<br>";
			}
		}
	}

	private function parse_subscriptions ($subscriptions) {
		foreach ($subscriptions as $subscription) {
			foreach ($subscription->childNodes as $child) {
				switch ($child->nodeName) {
					case "email":
					case "feed":
						$varname = $child->nodeName;
						$$varname = $child->nodeValue;
						break;
					case "date":
						$datetime = new DateTime ($child->nodeValue); 
						$date = $datetime->format ("c");
						break;
				}
			}
			try {
				$user = new User ($email);
				$user->subscribe_to_feed ($feed, $date);
			}
			catch (Exception $e) {
				echo "PARSE_SUBSCRIPTIONS Exception catched : ". $e->getMessage (). "<br>";
			}
		}
	}
}
echo "start<br>";
new Importer ("data/bdd_projet_0910_data.xml");
echo "end<br>";
?>