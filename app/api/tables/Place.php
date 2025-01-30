<?php
class Place
{

	private $table = "Places";
	public $id;
	public $name;
	public $description;
	public $latitude;
	public $longitude;
	public $upvotes;
	public $downvotes;


	public function __construct($db)
	{
		$this->conn = $db;
	}

	function getNearest($distance){
		$stmt = $this->conn->prepare("
		SELECT * FROM " . $this->table . " WHERE ST_Distance_Sphere(
			point(longitude, latitude),
			point(?, ?)
		) < ?");

		$stmt->bind_param("ddi", $this->longitude, $this->latitude, $distance);

		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	function getTop()
	{
		$stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY upvotes DESC LIMIT 10");
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	function getWorse(){
		$stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY downvotes DESC LIMIT 10");
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}


	function read()
	{
		if ($this->id >= 0) {
			$stmt = $this->conn->prepare("
			SELECT * FROM " . $this->table . " WHERE id = ?");
			$stmt->bind_param("i", $this->id);
		} else {
			$stmt = $this->conn->prepare("SELECT * FROM " . $this->table);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	function insert()
	{
		$stmt = $this->conn->prepare("
		    INSERT INTO " . $this->table . "(name, description, latitude, longitude) values(?, ?, ?, ?)");

		$this->name = strip_tags($this->name);
		$this->description = strip_tags($this->description);
		$this->latitude = strip_tags($this->latitude);
		$this->longitude = strip_tags($this->longitude);

		$stmt->bind_param("ssdd", $this->name, $this->description, $this->latitude, $this->longitude);
		if ($stmt->execute()) {

			return true;
		}
		return false;
	}


	function upvote()
	{
		$stmt = $this->conn->prepare("
		    UPDATE " . $this->table . " 
			SET upvotes = upvotes + 1 WHERE id = ?");

		$this->id = strip_tags($this->id);
		$stmt->bind_param("i", $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function downvote()
	{
		$stmt = $this->conn->prepare("
		    UPDATE " . $this->table . " 
			SET downvotes = downvotes + 1 WHERE id = ?");

		$this->id = strip_tags($this->id);
		$stmt->bind_param("i", $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
}
?>