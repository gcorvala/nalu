<?php
require_once ("core/user.php");
require_once ("core/feed.php");
require_once ("core/data.php");

class Item {
	private $url;
	private $title;
	private $date;
	private $description;
	private $note;
	private $share_date;
	private $comments;

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

	public function is_read ($user) {
		$data = Data::create ();
		$req = "SELECT * FROM db_projet.Reads WHERE Email = '" . $user->get_email () . "' AND URLItem = '$this->url'";
		$result = $data->request ($req);
		if (mysql_num_rows ($result) == 1)
			return true;
		else
			return false;
	}

	public function get_url () { return $this->url; }
	public function get_title () { return $this->title; }
	public function get_date () { return $this->date; }
	public function get_description () { return $this->description; }
	public function set_note ($note) { $this->note = $note; }
	public function get_note () { return $this->note; }
	public function set_share_date ($date) { $this->share_date = $date; }
	public function get_share_date () { return $this->share_date; }
	public function set_comments ($comments) { $this->comments = $comments; }
	public function get_comments () { return $this->comments; }
}
?>