<?
require_once ("core/data.php");
require_once ("core/rssfeed.php");
require_once ("core/rssitem.php");

class User {
	private $email;
	private $password;
	private $nickname;
	private $city;
	private $country;
	private $avatar;
	private $biography;
	private $subscribeDate;

	public function __construct ($email, $password, $nickname, $city, $country, $avatar, $biography) {
		$data = Data::create ();
		if (!isset ($password)) {
			$req = "SELECT * FROM Users WHERE Email LIKE '$email'";
			$result = $data->request ($req);
			if (mysql_num_rows ($result) == 0)
				throw new Exception ("User $email not found !");
			$line = mysql_fetch_array ($result);
			$this->email = $line['Email'];
			$this->password = $line['Password'];
			$this->nickname = $line['Nickname'];
			$this->city = $line['City'];
			$this->country = $line['Country'];
			$this->avatar = $line['Avatar'];
			$this->biography = $line['Biography'];
			$this->subscribeDate = $line['SubscribeDate'];
		}
		else {
			$this->email = $email;
			$this->password = $password;
			$this->nickname = $nickname;
			$this->city = $city;
			$this->country = $country;
			$this->avatar = $avatar;
			$this->biography = $biography;
			$this->subscribeDate = date_format (date_create (), "c");
			$req = "INSERT INTO Users (Email, Password, Nickname, City, Country, Avatar, Biography, SubscribeDate)";
			$req .= " VALUES ('$this->email', '$this->password', '$this->nickname', '$this->city', '$this->country', '$this->avatar', '$this->biography', '$this->subscribeDate')";
			$data->request ($req);
		}
	}
	
	public function get_email () { return $this->email; }
	public function get_password () { return $this->password; }
	public function get_nickname () { return $this->nickname; }
	public function get_city () { return $this->city; }
	public function get_country () { return $this->country; }
	public function get_avatar () { return $this->avatar; }
	public function get_biography () { return $this->biography; }
	public function get_subscribe_date () { return $this->subscribeDate; }

	public function get_friends () {
		$friends = array ();
		$data = Data::create ();
		$req = "SELECT * FROM Friends WHERE (EmailA = '$this->email' OR EmailB = '$this->email') AND Accepted = 1";
		$result = $data->request ($req);
		while ($line = mysql_fetch_array ($result)) {
			if ($line['EmailA'] == $this->email)
				$friends[] = new User ($line['EmailB']);
			else
				$friends[] = new User ($line['EmailA']);
		}
		return $friends;
	}

	public function subscribe_to_feed ($url) {
		$feed = new RSSFeed ($url);
		$data = Data::create ();
		$req = "INSERT INTO FeedSubscriptions (Email, URL, Date)";
		$req .= " VALUES ('$this->email', '" . $feed->get_url () . "', '" . date_format (date_create (), "c") . "')";
		$result = $data->request ($req);
	}

	public function get_feeds () {
		$feeds = array ();
		$data = Data::create ();
		$req = "SELECT URL FROM FeedSubscriptions WHERE Email LIKE '$this->email'";
		$result = $data->request ($req);
		while ($line = mysql_fetch_array ($result))
			$feeds[] = new RSSFeed ($line['URL']);
		return $feeds;
	}

	public function get_own_feed () {
		return new RSSFeed ("user://" . $this->email);
	}

	public function read ($item) {
		$data = Data::create ();
		$item_url = $item->get_url ();
		$read_date = date_format (date_create (), "c");
		$req = "INSERT INTO ItemsReaded (Email, URL, Date)";
		$req .= " VALUES ('$this->email', '$item_url', '$read_date')";
		$data->request ($req);
	}

	public function get_items_readed () {}
}
?>