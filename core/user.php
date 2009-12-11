<?php
require_once ("core/data.php");
require_once ("core/feed.php");
require_once ("core/item.php");

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
			$this->email = utf8_decode ($email);
			$this->password = utf8_decode ($password);
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
			$feed = new Feed ("user://" . $this->email);
			$this->subscribe_to_feed ($feed, $this->subscribeDate);
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
		$req = "SELECT URL FROM Subscriptions WHERE (Email LIKE '$this->email' AND URL NOT LIKE 'user://$this->email')";
		$result = $data->request ($req);
		while ($line = mysql_fetch_array ($result))
			$feeds[] = new Feed ($line['URL']);
		return $feeds;
	}

	public function get_own_feed () {
		return new Feed ("user://" . $this->email);
	}

	public function subscribe_to_feed ($feed, $date) {
		$data = Data::create ();
		if (!isset ($date))
			$subscribe_date = date_format (date_create (), "c");
		else
			$subscribe_date = $date;
		$req = "INSERT INTO Subscriptions (Email, URL, Date)";
		$req .= " VALUES ('$this->email', '" . $feed->get_url () . "', '$subscribe_date')";
		$result = $data->request ($req);
	}

	public function unsubscribe_to_feed ($feed) {
		$data = Data::create ();
		$req = "DELETE FROM Subscriptions WHERE Email = '$this->email' AND URL = '" . $feed->get_url () . "'";
		$data->request ($req);
		$req = "SELECT COUNT(*) FROM Subscriptions WHERE URL = '" . $feed->get_url () . "'";
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

	public function add_friend ($user, $date) {
		$data = Data::create ();
		$req = "SELECT Accepted FROM Friends WHERE (EmailA = '" . $user->get_email () . "' AND EmailB = '$this->email')";
		$result = $data->request ($req);
		if (mysql_num_rows ($result) == 0) {
			$req = "INSERT INTO Friends (EmailA, EmailB, Date, Accepted)";
			$req .= " VALUES ('$this->email', '" . $user->get_email () . "', '$date', 0)";
			$data->request ($req);
		}
		else {
			$accepted = mysql_fetch_array ($result);
			if ($accepted[0] == 0) {
				$req = "UPDATE Friends SET Accepted = 1 WHERE (EmailA = '" . $user->get_email () . "' AND EmailB = '$this->email')";
				$data->request ($req);
			}
		}
	}

	public function remove_friend ($friend) {
		$data = Data::create ();
		$friend_email = $friend->get_email ();
		$req = "DELETE FROM Friends WHERE (EmailA = '$this->email' AND EmailB = '$friend_email') OR (EmailB = '$this->email' AND EmailA = '$friend_email')";
		$data->request ($req);
		$this->unsubscribe_to_feed ($friend->get_own_feed ());
	}

	public function set_item_readed ($feed, $item, $date) {
		$data = Data::create ();
		if (!isset ($date))
			$read_date = date_format (date_create (), "c");
		else
			$read_date = $date;
		$req = "INSERT INTO Reads (Email, URLFeed, URLItem, Date)";
		$req .= " VALUES ('$this->email', '" . $feed->get_url () . "', '" . $item->get_url () . "', '$read_date')";
		$data->request ($req);
	}

	public function add_comment ($feed, $item, $text, $date) {
		echo "comm";
		$data = Data::create ();
		if (!isset ($date))
			$comment_date = date_format (date_create (), "c");
		else
			$comment_date = $date;
		$req = "INSERT INTO Comments (Email, Text, URLFeed, URLItem, Date)";
		$req .= " VALUES ('$this->email', '$text', '" . $feed->get_url () . "', '" . $item->get_url () . "', '$comment_date')";
		$data->request ($req);
	}

	public function set_item_not_readed () {}
	public function get_items_readed () {}
	public function get_items_not_readed () {}
	public function share ($feed, $item, $note, $date) {
		$data = Data::create ();
		$req = "INSERT INTO Shares (URLFeed, URLItem, Email, Note, Date)";
		$req .= " VALUES ('" . $feed->get_url () . "', '" . $item->get_url () . "', '$this->email' ,'$note', '$date')";
		$data->request ($req);
	}
	public function unshare ($feed, $item) {}
	public function remove_comment () {}
}
?>