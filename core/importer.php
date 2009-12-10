<?php
class importer {
	private $mysql_connection;
	
	public function __construct () {}

	public function connection () {
		$mysql_link = mysql_connect ("localhost:8889", "root", "root")
			or die ("Mysql connection failed! : " . mysql_error ());
		mysql_select_db ("db_projet", $mysql_link)
			or die ("Mysql database selection failed! : " . mysql_error ());
	} 

	private function insert_user ($email, $password, $nickname, $city, $country, $avatar, $biography, $subscribeDate) {
		$mysql_req = "INSERT INTO Users (Email, Password, Nickname, City, Country, Avatar, Biography, SubscribeDate)";
		$mysql_req .= " VALUES ('$email', '$password', '$nickname', '$city', '$country', '$avatar', '$biography', '$subscribeDate')";
		
		$this->connection ();
		$result = mysql_query ($mysql_req);
		
		if ($result == false) {
			if (mysql_errno () == 1062)
				$string = "<b>This user ($email) already exists!</b>";
			else
				die ("Error during MYSQL request : " . mysql_error ());
		}
		else
			$string = "Insertion of ($email) was successfull!";
		
		return $string;
	}

	private function insert_friend ($emailA, $emailB, $date, $accepted) {
		$this->connection ();

		$mysql_req = "SELECT EmailA, EmailB FROM friends WHERE (EmailA = '$emailB' AND EmailB = '$emailA')";
		$result = mysql_query ($mysql_req);
		if (mysql_num_rows ($result) != 0)
			return "<b>The relationship ($emailB - $emailA) already exists!</b>";

		$mysql_req = "INSERT INTO friends (EmailA, EmailB, Date, Accepted)";
		$mysql_req .= " VALUES ('$emailA', '$emailB', '$date', '$accepted')";
		
		$result = mysql_query ($mysql_req);
		
		if ($result == false) {
			if (mysql_errno () == 1062)
				return "<b>The realationship ($emailA - $emailB) already exists!</b>";
			else
				die ("Error during MYSQL request : " . mysql_error ());
		}
		else
			return "Insertion of ($emailA - $emailB) was successfull!";
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

			$string = "<p><tt>";
			$string .= "+-New User--------------------------------<br>";
			$string .= "| email     : $email<br>";
			$string .= "| password  : $password<br>";
			$string .= "| nickname  : $nickname<br>";
			$string .= "| city      : $city<br>";
			$string .= "| country   : $country<br>";
			$string .= "| avatar    : $avatar<br>";
			$string .= "| biography : $biography<br>";
			$string .= "| subscribe : $subscribeDate<br>";
			$string .= "| MYSQL     : " . $this->insert_user ($email, $password, $nickname, $city, $country, $avatar, $biography, $subscribeDate, $mysql_req);
			$string .= "</tt></p>";

			$string = str_replace (" ", "&nbsp;", $string);
			echo $string;
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
			
			$string = "<p><tt>";
			$string .= "+-New Friends-----------------------------<br>";
			$string .= "| email    : $email[0]<br>";
			$string .= "| email    : $email[1]<br>";
			$string .= "| date     : $date<br>";
			$string .= "| accepted : $accepted<br>";
			$string .= "| MYSQL    : " . $this->insert_friend ($email[0], $email[1], $date, $accepted);
			$string .= "</tt></p>";

			$string = str_replace (" ", "&nbsp;", $string);
			echo $string;
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
			
			$mysql_req = "INSERT INTO reads (email, item, feed, date)";
			$mysql_req .= " VALUES ('$email', '$item', '$feed', '$date')";
			
			$string = "<p><tt>";
			$string .= "+-New Read--------------------------------<br>";
			$string .= "| email : $email<br>";
			$string .= "| date  : $date<br>";
			$string .= "| feed  : $feed<br>";
			$string .= "| item  : $item<br>";
			$string .= "| MYSQL : $mysql_req<br>";
			$string .= "</tt></p>";
			$string = str_replace (" ", "&nbsp;", $string);
			echo $string;
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
			
			$mysql_req = "INSERT INTO comments (email, text, feed, item, date)";
			$mysql_req .= " VALUES ('$email', '$text', '$feed', '$item', '$date')";
			
			$string = "<p><tt>";
			$string .= "+-New Comment-----------------------------<br>";
			$string .= "| email : $email<br>";
			$string .= "| text  : $text<br>";
			$string .= "| feed  : $feed<br>";
			$string .= "| item  : $item<br>";
			$string .= "| date  : $date<br>";
			$string .= "| MYSQL : $mysql_req<br>";
			$string .= "</tt></p>";
			$string = str_replace (" ", "&nbsp;", $string);
			echo $string;
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
			
			$mysql_req = "INSERT INTO shares (feed, item, email, text, date)";
			$mysql_req .= " VALUES ('$feed', '$item', '$email', '$text', '$date')";
			
			$string = "<p><tt>";
			$string .= "+-New Share-------------------------------<br>";
			$string .= "| feed  : $feed<br>";
			$string .= "| item  : $item<br>";
			$string .= "| email : $email<br>";
			$string .= "| text  : $text<br>";
			$string .= "| date  : $date<br>";
			$string .= "| MYSQL : $mysql_req<br>";
			$string .= "</tt></p>";
			$string = str_replace (" ", "&nbsp;", $string);
			echo $string;
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
			
			$mysql_req = "INSERT INTO subscriptions (email, feed, date)";
			$mysql_req .= " VALUES ('$email', '$feed', '$date')";
			
			$string = "<p><tt>";
			$string .= "+-New Subscription------------------------<br>";
			$string .= "| email : $email<br>";
			$string .= "| feed  : $feed<br>";
			$string .= "| date  : $date<br>";
			$string .= "| MYSQL : $mysql_req<br>";
			$string .= "</tt></p>";
			$string = str_replace (" ", "&nbsp;", $string);
			echo $string;
		}
	}

	public function from_xml ($xml) {
		$doc = new DOMDocument ();
		$xml_content = file_get_contents ($xml);
		$dtd_content = file_get_contents ("bdd_projet_0910_data.dtd");
		//echo $dtd_content. $xml_content;
		$doc->loadXML ($dtd_content. $xml_content, LIBXML_DTDLOAD | LIBXML_DTDVALID);
		if ($doc->validate () == true)
			echo "yes<br>";
		else
			echo "no!<br>";
		$users = $doc->getElementsByTagName ("user");
		$this->parse_users ($users);
		$friends = $doc->getElementsByTagName ("friend");
		$this->parse_friends ($friends);
		$reads = $doc->getElementsByTagName ("read");
		$this->parse_reads ($reads);
		$comments = $doc->getElementsByTagName ("comment");
		$this->parse_comments ($comments);
		$shares = $doc->getElementsByTagName ("share");
		$this->parse_shares ($shares);
		$subscriptions = $doc->getElementsByTagName ("subscription");
		$this->parse_subscriptions ($subscriptions);
		echo "end";
	}
}

$importer = new Importer ();
$importer->connection ();
$importer->from_xml ("bdd_projet_0910_data.xml");
echo "lol";
?>