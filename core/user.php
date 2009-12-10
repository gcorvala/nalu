<?php
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

	public function __construct ($email, $password, $nickname, $city, $country, $avatar, $biography, $subscribeDate) {
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
			$this->nickname = utf8_decode ($nickname);
			$this->city = utf8_decode ($city);
			$this->country = utf8_decode ($country);
			$this->avatar = $avatar;
			$this->biography = utf8_decode ($biography);
			if (!isset ($subscribeDate))
				$this->subscribeDate = date_format (date_create (), "c");
			else
				$this->subscribeDate = utf8_decode ($subscribeDate);
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

	public function subscribe_to_feed ($url, $date) {
		$data = Data::create ();
		$feed = new RSSFeed ($url);
		if (!isset ($date))
			$subscribe_date = date_format (date_create (), "c");
		else
			$subscribe_date = $date;
		$req = "INSERT INTO FeedSubscriptions (Email, URL, Date)";
		$req .= " VALUES ('$this->email', '" . $feed->get_url () . "', '$subscribe_date')";
		$result = $data->request ($req);
	}

	public function set_item_readed ($item, $date) {
		$data = Data::create ();
		if (!isset ($date))
			$read_date = date_format (date_create (), "c");
		else
			$read_date = $date;
		$req = "INSERT INTO ItemsReaded (Email, URL, Date)";
		$req .= " VALUES ('$this->email', '$item', '$read_date')";
		$data->request ($req);
	}

	public function unsubscribe_to_feed ($feed) {
		$data = Data::create ();
		$req = "DELETE FROM FeedSubscriptions WHERE Email = '$this->email' AND URL = '" . $feed->get_url () . "'";
		$data->request ($req);
		$req = "SELECT COUNT(*) FROM FeedSubscriptions WHERE URL = '" . $feed->get_url () . "'";
		$result = mysql_fetch_array ($data->request ($req));
		echo $result[0] . "<br>";
		if ($result[0] == 0) {
			$req = "DELETE FROM Items WHERE URL = '" . $feed->get_url () . "'";
			$data->request ($req);
			$req = "DELETE FROM FeedItems WHERE URLFeed = '" . $feed->get_url () . "'";
			$data->request ($req);
			$req = "DELETE FROM Feeds WHERE URL = '" . $feed->get_url () . "'";
			$data->request ($req);
		}
	}

	public function set_item_not_readed () {}
	public function get_items_readed () {}
	public function get_items_not_readed () {}
	public function set_item_shared ($item, $comment) {}
	public function unset_item_shared () {}
	public function add_comment () { echo "add_comment TODO<br>"; }
	public function remove_comment () {}
	public function add_friend () { echo "add_friend TODO<br>"; }
	public function remove_friend () {}
}
?>