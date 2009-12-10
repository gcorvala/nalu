<?php
require_once ("core/data.php");
require_once ("core/rssitem.php");

class RSSFeed {
	private $url;
	private $name;
	private $description;
	private $link;
	private $dom;
	private $user_feed = false;

	public function __construct ($url) {
		if (empty ($url))
			throw new Exception ("RSSFeed : url are not defined !");
		$this->url = $url;
		// TODO : si user_feed et pas dans la db -> Exception
		if (ereg("^user://", $this->url))
			$user_feed = true;
		$data = Data::create ();
		$req = "SELECT * FROM Feeds WHERE URL LIKE '$this->url'";
		$result = $data->request ($req);
		if (mysql_num_rows ($result) == 0) {
			$this->dom = new DOMDocument ();
			$xml = file_get_contents('http://www.dpreview.com/feeds/news.xml');
			if ($this->dom->load ($this->url) == false)
				throw new Exception ("RSSFeed : url cannot be fetched ! : $this->url");
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
			$result = $data->request ($req);
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
			$items[] = new RSSItem ($line['URLItem']);
		}
		return $items;
	}
	
	/**
	 * This function returns the list of items that we insert in the db
	 **/
	public function update_items () {
		if (!isset ($this->dom)) {
			$this->dom = new DOMDocument ();
			if ($this->dom->load ($this->url) == false)
				throw new Exception ("RSSFeed : url cannot be fetched !");
		}
		$items = array ();
		$xml_items = $this->dom->getElementsByTagName ("item");
		$data = Data::create ();
		foreach ($xml_items as $item) {
			foreach ($item->childNodes as $child) {
				$node = $child->nodeName;
				$$node = $child->nodeValue;
			}
			$req = "SELECT * FROM Items WHERE URL LIKE '$link'";
			$result = $data->request ($req);
			if (mysql_num_rows ($result) == 0) {
				$items[] = new RSSItem ($link, $title, $pubDate, $description);
				$req = "INSERT INTO FeedItems (URLFeed, URLItem)";
				$req .= " VALUES ('$this->url', '$link')";
				$data->request ($req);
			}
		}
	}
}
?>
