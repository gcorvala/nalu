<?php
require_once ("core/config.php");
require_once ("core/feed.php");
require_once ("core/item.php");
require_once ("core/user.php");

class Importer {
	public function __construct ($xml) {
		$doc = new DOMDocument ();
		$xml_content = file_get_contents ($xml);
		if ($xml_content == false)
			throw new Exception ("Error loading : $xml");
		$doc->loadXML ($xml_content);
		$users = $doc->getElementsByTagName ("user");
		$this->parse_users ($users);
		$friends = $doc->getElementsByTagName ("friend");
		$this->parse_friends ($friends);
		$subscriptions = $doc->getElementsByTagName ("subscription");
		$this->parse_subscriptions ($subscriptions);
		$reads = $doc->getElementsByTagName ("read");
		$this->parse_reads ($reads);
		$comments = $doc->getElementsByTagName ("comment");
		$this->parse_comments ($comments);
		$shares = $doc->getElementsByTagName ("share");
		$this->parse_shares ($shares);
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
				$userA = new User ($email[0]);
				$userB = new User ($email[1]);
				$userA->add_friend ($userB);
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
				$feed = new Feed ($feed);
				$item = new Item ($item);
				$user->set_item_readed ($feed, $item, $date);
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
				$feed = new Feed ($feed);
				$user->subscribe_to_feed ($feed, $date);
			}
			catch (Exception $e) {
				echo "PARSE_SUBSCRIPTIONS Exception catched : ". $e->getMessage (). "<br>";
			}
		}
	}

	private function parse_comments ($comments) {
		foreach ($comments as $comment) {
			foreach ($comment->childNodes as $child) {
				switch ($child->nodeName) {
					case "email":
					case "text":
					case "feed":
					case "item":
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
				$feed = new Feed ($feed);
				$item = new Item ($item);
				$user->add_comment ($feed, $item, $text, $date);
			}
			catch (Exception $e) {
				echo "PARSE_COMMENTS Exception catched : ". $e->getMessage (). "<br>";
			}
		}
	}

	private function parse_shares ($shares) {
		foreach ($shares as $share) {
			foreach ($share->childNodes as $child) {
				switch ($child->nodeName) {
					case "feed":
					case "item":
					case "email":
					case "text":
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
				$feed = new Feed ($feed);
				$item = new Item ($item);
				$user->share ($feed, $item, $text, $date);
			}
			catch (Exception $e) {
				echo "PARSE_SHARES Exception catched : ". $e->getMessage (). "<br>";
			}
		}
	}
}
echo "start<br>";
try {
	$feed = new Feed ("http://www.lesoir.be/services/rss/la_une/index.xml", "data/lesoir.xml");
	$feed->update ();
	$feed = new Feed ("http://www.lalibre.be/rss/index.xml", "data/lalibre.xml");
	$feed->update ();
	$feed = new Feed ("http://valves.bepolytech.be/valves_ba3.rss", "data/valves_ba3.xml");
	$feed->update ();
	$feed = new Feed ("http://xkcd.com/rss.xml", "data/xkcd.xml");
	$feed->update ();
	$feed = new Feed ("http://failblog.wordpress.com/feed/", "data/failblog.xml");
	$feed->update ();
	$feed = new Feed ("http://syndication.thedailywtf.com/TheDailyWtf", "data/TheDailyWtf.xml");
	$feed->update ();
	// FIXME : Atom ? RSS ?
	//$feed = new Feed ("http://sboucher.blogspot.com/feeds/posts/default?alt=rss", "data/sergeblog.xml");
	//$feed->update ();
	$feed = new Feed ("http://www.ulb.ac.be/actulb/rss/lastnews.rss", "data/ACT'ULB.xml");
	$feed->update ();
	new Importer ("data/bdd_projet_0910_data.xml");
}
catch (Exception $e) {
	echo $e->getMessage () . "<br>";
}
echo "end<br>";
?>