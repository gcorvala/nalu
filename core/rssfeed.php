<?
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

		if (ereg("^user://", $this->url))
			$user_feed = true;

		if ($user_feed == true) {
			echo "FEED FROM DB<br>";
		}
		else
			echo "FEED FROM XML<br>";

		$data = Data::create ();
		$req = "SELECT * FROM Feeds WHERE URL LIKE '$this->url'";
		$result = $data->request ($req);
		if (mysql_num_rows ($result) == 0) {
			$this->dom = new DOMDocument ();
			if ($this->dom->load ($this->url) == false)
				throw new Exception ("RSSFeed : url cannot be fetched !");
			$channel = $this->dom->getElementsByTagName ("channel");
			$channel = $channel->item (0);
			foreach ($channel->childNodes as $child) {
				$node = $child->nodeName;
				$$node = $child->nodeValue;
			}
			$this->name = $title;
			$this->description = $description;
			$this->link = $link;

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
		echo "<tt>+-Feed<br>";
		echo "| URL : $this->url<br>";
		echo "| Name : $this->name<br>";
		echo "| Description : $this->description<br>";
		echo "| Link : $this->link<br></tt>";
	}
	
	public function get_url () { return $this->url; }
	public function get_name () { return $this->name; }
	public function get_description () { return $this->description; }
	public function get_link () { return $this->link; }
	
	public function get_items () {
		$items = array ();
		$xml_items = $this->dom->getElementsByTagName ("item");
		foreach ($xml_items as $item) {
			foreach ($item->childNodes as $child) {
				$node = $child->nodeName;
				$$node = $child->nodeValue;
			}
			//$pubDate = date_format (date_create (), "c");
			//echo $pubDate;
			$items[] = new RSSItem ($link, $title, $pubDate, $description);
		}
		return $items;
	} 
}
?>