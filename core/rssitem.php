<?
class RSSItem {
	private $url;
	private $title;
	private $date;
	private $description;
	
	public function __construct ($url, $title, $date, $description) {
		if (empty ($url) or empty ($title) or empty ($description))
			throw new Exception ("RSSItem : url, title or description are empty !");

		$this->url = $url;
		$this->title = $title;
		$this->description = $description;

		if (empty ($date))
			$this->date = date_format (date_create (), "c");
		else
			$this->date = $date;
		echo "<tt>+-Item<br>";
		echo "| URL : $this->url<br>";
		echo "| Title : $this->title<br>";
		echo "| Date : $this->date<br>";
		echo "| Description : $this->description<br></tt>";
	}
	
	public function get_url () { return $this->url; }
	public function get_title () { return $this->title; }
	public function get_date () { return $this->date; }
	public function get_description () { return $this->description; }
}
?>