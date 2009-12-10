<?php
require_once ("core/data.php");

class RSSItem {
	private $url;
	private $title;
	private $date;
	private $description;
	
	public function __construct ($url, $title, $date, $description) {
		$data = Data::create ();
		if (!isset ($title)) {
			$req = "SELECT * FROM Items WHERE URL LIKE '$url'";
			$result = $data->request ($req);
			if (mysql_num_rows ($result) == 0)
				throw new Exception ("Item $url not found !");
			$line = mysql_fetch_array ($result);
			$this->url = $line['URL'];
			$this->title = $line['Title'];
			$this->date = $line['Date'];
			$this->description = $line['Description'];
		}
		else {
			$this->url = utf8_decode (addslashes ($url));
			$this->title = utf8_decode (addslashes ($title));
			$this->description = utf8_decode (addslashes ($description));
			if (empty ($date))
				$this->date = date_format (date_create (), "c");
			else
				$this->date = $date;
			$req = "INSERT INTO Items (URL, Title, Date, Description)";
			$req .= " VALUES ('$this->url', '$this->title', '$this->date', '$this->description')";
			$data->request ($req);
		}
	}
	
	public function get_url () { return $this->url; }
	public function get_title () { return $this->title; }
	public function get_date () { return $this->date; }
	public function get_description () { return $this->description; }

	public function is_readed ($user) {
		$data = Data::create ();
		//$req = "SELECT "
	}
}
?>