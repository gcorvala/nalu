<?
class Auth {
	// TODO : Rendre cette classe Singleton
	private $user;

	public function __construct () {
		//if (!isset ($_SESSION['Email'])) {
//			if (isset ($_POST) && !empty ($_POST['email']) && !empty($_POST['password'])) {
//				extract($_POST);
			if (isset ($_GET) && !empty ($_GET['email']) && !empty($_GET['password'])) {
				extract ($_GET);

				$mysql_req = "SELECT * FROM Users WHERE (Email = '$email' AND Password = '$password')";

				$result = mysql_query ($mysql_req);
				if ($result == false)
					throw new Exception (get_class ($this) . " : Error during MYSQL request : " . mysql_error ());
				if (mysql_num_rows ($result) == 0) {
					session_destroy ();
					throw new Exception (get_class ($this) . " : Bad email or password !");
				}

				$line = mysql_fetch_array ($result);
//				if ($password != $line['Password'])
//					throw new Exception (get_class ($this) . " : Bad password !");

				session_start ();
				$_SESSION['Email'] = $line['Email'];
				$_SESSION['Password'] = $line['Passwors'];

				$this->user = new User ($line['Email'], $line['Password'], $line['Nickname'], $line['City'], $line['Country'], $line['Avatar'], $line['Biography'], $line['SubscribeDate']);
			}
		//}
		else {
			session_start ();
			if (isset ($_SESSION['Email'])) {
				$mysql_req = "SELECT * FROM Users WHERE Email = '$email'";

				$result = mysql_query ($mysql_req);
				if ($result == false)
					throw new Exception (get_class ($this) . " : Error during MYSQL request : " . mysql_error ());
				if (mysql_num_rows ($result) == 0) {
					session_destroy ();
					throw new Exception (get_class ($this) . " : Bad email or password !");
				}

				$line = mysql_fetch_array ($result);
//				if ($password != $line['Password'])
//					throw new Exception (get_class ($this) . " : Bad password !");

				//session_start ();
				//$_SESSION['Email'] = $line['Email'];
				//$_SESSION['Password'] = $line['Passwors'];

				$this->user = new User ($line['Email'], $line['Password'], $line['Nickname'], $line['City'], $line['Country'], $line['Avatar'], $line['Biography'], $line['SubscribeDate']);
				//echo $_SESSION['Email'];
			}
			if(!isset ($_SESSION['Email']))
//			FIXME : Exception or return anonymour ?
//			throw new Exception (get_class ($this) . " : user is not authenticated !");
				$this->user = new User ("anonymous");
		}
	}

	public function get_user () {
		return $this->user;
	}
}

?>