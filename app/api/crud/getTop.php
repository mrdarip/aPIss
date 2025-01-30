<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once '../database/Bathrooms.php';
include_once '../tables/Place.php';

$database = new Bathroom();
$con = $database->getConnection();
$place = new Place($con);

$result = $place->getTop();
if ($result->num_rows > 0) {
    $arrayPlaces = array();  
    while ($extractedPlace = $result->fetch_assoc()) { 
        extract($extractedPlace);
        $extractedData = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "upvotes" => $upvotes,
            "downvotes" => $downvotes
        );
        array_push($arrayPlaces, $extractedData);
    }

    http_response_code(200);
    echo json_encode($arrayPlaces);

} else { 
    http_response_code(404);
    echo json_encode(
        array("info" => "No place found near you")
    );
}


?>