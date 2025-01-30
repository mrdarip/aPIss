<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../database/Bathrooms.php';
include_once '../tables/Place.php';

$database = new Bathroom();
$con = $database->getConnection();
$place = new Place($con);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->name) && isset($data->description) && isset($data->latitude) && isset($data->longitude)) {
    $place->name = $data->name;
    $place->description = $data->description;
    $place->latitude = $data->latitude;
    $place->longitude = $data->longitude;

    if ($place->insert()) {
        http_response_code(201);
        echo json_encode(array("info" => "Place created successfully"));
    } else {
        http_response_code(503);
        echo json_encode(array("info" => "Unable to create place"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("info" => "Unable to create place, incomplete data"));
}

?>