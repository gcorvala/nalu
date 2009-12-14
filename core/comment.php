<?php
class Comment {
	private $email;
	private $text;
	private $date;

	public function __construct ($email, $text, $date) {
		$this->email = $email;
		$this->text = $text;
		$this->date = $date;
	}

	public function get_email () { return $this->email; }
	public function get_text () { return $this->text; }
	public function get_date () { return $this->date; }
}
?>