<?php
class Bathroom
{
	private $host = 'localhost';
	private $user = 'admin';
	private $password = "bgLS8bW8eCJk";
	private $database = "Bathrooms";

	public function getConnection()
	{
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
		$conn->set_charset("utf8");
		if ($conn->connect_error) {
			die("Error on connection with MYSQL" . $conn->connect_error);
		} else {
			return $conn;
		}
	}
}
?>