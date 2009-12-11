<?php
require_once ("core/data.php");
require_once ("core/item.php");

class Feed {
	private $url;
	private $name;
	private $description;
	private $link;
	private $dom;
	private $user_feed = false;

	public function __construct ($url) {
		if (empty ($url))
			throw new Exception ("Feed : url are not defined !");
		$this->url = $url;
		// FIXME : what should we insert for user_feed name, description and link ?
		if (ereg("^user://", $this->url))
			$user_feed = true;
		$data = Data::create ();
		$req = "SELECT * FROM Feeds WHERE URL LIKE '$this->url'";
		$result = $data->request ($req);
		if (mysql_num_rows ($result) == 0) {
			if ($user_feed == true) {
				$req = "INSERT INTO Feeds (URL)";
				$req .= " VALUES ('$this->url')";
				$data->request ($req);
			}
			else {
				$this->dom = new DOMDocument ();
				if ($this->dom->load ($this->url) == false)
					throw new Exception ("Feed : url cannot be fetched ! : $this->url");
				$channel = $this->dom->getElementsByTagName ("channel");
				$channel = $channel->item (0);
				foreach ($channel->childNodes as $child) {
					$node = $child->nodeName;
					$$node = $child->nodeValue;
				}
				$this->name = utf8_decode (addslashes ($title));
				$this->description = utf8_decode (addslashes ($description));
				$this->link = utf8_decode (addslashes ($link));
				$req = "INSERT INTO Feeds (URL, Name, Description, Link)";
				$req .= " VALUES ('$this->url', '$this->name', '$this->description', '$this->link')";
				$data->request ($req);
			}
		}
		else {
			$line = mysql_fetch_array ($result);
			$this->name = $line['Name'];
			$this->description = $line['Description'];
			$this->link = $line['Link'];
		}
	}
	
	public function get_url () { return $this->url; }
	public function get_name () { return $this->name; }
	public function get_description () { return $this->description; }
	public function get_link () { return $this->link; }
	
	public function get_items () {
		$data = Data::create ();
		$items = array ();
		$req = "SELECT * FROM FeedItems WHERE URLFeed LIKE '$this->url'";
		$result = $data->request ($req);
		while ($line = mysql_fetch_array ($result)) {
			$items[] = new Item ($line['URLItem']);
		}
		return $items;
	}

	public function add ($item) {
		$data = Data::create ();
		$req = "INSERT INTO FeedItems (URLFeed, URLItem)";
		$req .= " VALUES ('$this->url', '" . $item->get_url () . "')";
		$data->request ($req);
	}

	public function update () {
		if ($user_feed == true)
			return;
		if (!isset ($this->dom)) {
			$this->dom = new DOMDocument ();
			if ($this->dom->load ($this->url) == false)
				throw new Exception ("Feed : url cannot be fetched !");
		}
		$xml_items = $this->dom->getElementsByTagName ("item");
		$data = Data::create ();
		foreach ($xml_items as $item) {
			foreach ($item->childNodes as $child) {
				$node = $child->nodeName;
				$$node = $child->nodeValue;
			}
			// FIXME : Select is not needed (because checked into Item)
			$req = "SELECT * FROM Items WHERE URL LIKE '$link'";
			$result = $data->request ($req);
			if (mysql_num_rows ($result) == 0) {
				$new_item = new Item ($link, $title, $pubDate, $description);
				$this->add ($new_item);
			}
		}
	}
}
?>