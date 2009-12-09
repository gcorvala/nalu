<?
require_once ("config.php");

class Data {
	private static $instance;
	private $link;

	private function __construct () {
		$config = new Config ();
		$this->link = mysql_connect ($config->get_mysql_srv_addr () . ":" . $config->get_mysql_srv_port (),
									$config->get_mysql_srv_user (),
									$config->get_mysql_srv_pass ());
		if ($this->link == false)
			throw new Exception ("Mysql connection failed! : " . mysql_error ());
		if (mysql_select_db ($config->get_mysql_db_name (), $this->link) == false)
			throw new Exception ("Mysql database selection failed! : " . mysql_error ());
	}
	
	public static function create () {
		if (!isset (self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	public function request ($req) {
		$result = mysql_query ($req, $this->link);
		if ($result == false)
			throw new Exception ("Mysql request failed! : " . mysql_error ());
		return $result;
	}
	
	public function __destruct () {
		if (mysql_close ($this->link) == false)
			throw new Exception ("Mysql disconnection failed! : " . mysql_error ());
	}
}
?>