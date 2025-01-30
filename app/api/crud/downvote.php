<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../database/Bathrooms.php';
include_once '../tables/Place.php';

$database = new Bathroom();
$db = $database->getConnection();
$place = new Place($db);

$data = json_decode(file_get_contents("php://input"));

if( isset($data->id)){    
	$place->id = $data->id;

	if ($place->downvote()) {
		http_response_code(200);
		echo json_encode(array("info" => "Downvoted successfully!"));
	} else {
		http_response_code(503);
		echo json_encode(array("info" => "Error, could not downvote"));
	}

} else {
	http_response_code(400);
	echo json_encode(array("info" => "Can't downvote, missing id"));
}
?>