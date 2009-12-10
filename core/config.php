<?php
class Config {
	private $mysql_srv_addr;
	private $mysql_srv_port;
	private $mysql_srv_user;
	private $mysql_srv_pass;
	private $mysql_db_name;
	private $site_name;
	private $site_url;
	private $site_theme;

	public function __construct () {
		$ini = parse_ini_file (getcwd () . "/config.ini", true);
		$mysql = $ini['mysql'];
		$this->mysql_srv_addr = $mysql['srv_addr'];
		$this->mysql_srv_port = $mysql['srv_port'];
		$this->mysql_srv_user = $mysql['srv_user'];
		$this->mysql_srv_pass = $mysql['srv_pass'];
		$this->mysql_db_name = $mysql['db_name'];
		$site = $ini['site'];
		$this->site_name = $site['name'];
		$this->site_url = $site['url'];
		$this->site_theme = $site['theme'];
	}
	
	public function get_mysql_srv_addr () { return $this->mysql_srv_addr; }
	public function get_mysql_srv_port () { return $this->mysql_srv_port; }
	public function get_mysql_srv_user () { return $this->mysql_srv_user; }
	public function get_mysql_srv_pass () { return $this->mysql_srv_pass; }
	public function get_mysql_db_name () { return $this->mysql_db_name; }
	public function get_site_name () { return $this->site_name; }
	public function get_site_url () { return $this->site_url; }
	public function get_site_theme () { return $this->site_theme; }
	public function get_site_theme_folder () { return "themes/" . $this->site_theme; }
}
?>