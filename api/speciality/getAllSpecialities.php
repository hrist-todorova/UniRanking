<?php
header('Content-type: application/json');

require_once(realpath( "../../resources/config.php"));
$conn = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);
if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

$conn->set_charset("utf8");

$specialities = $conn->query("SELECT * FROM ". $config["db"]["name"] .".speciality");
$response = array();

if ($specialities->num_rows > 0) {
    while($row = $specialities->fetch_assoc()) {
        array_push($response, array("id" => intval($row['ID']), "name" => $row['Name'], "isActive" => false));
    }
} 

$conn->close();
echo json_encode($response);