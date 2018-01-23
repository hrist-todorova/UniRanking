<?php

$specialityId = $_GET['specialityId'];

require_once(realpath( "../../resources/config.php"));

$conn = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);
if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

$conn->set_charset("utf8");

$ranking = $conn->query("SELECT * FROM uni_ranking." . $specialityId);
$response = array();

if ($ranking->num_rows > 0) {
  while($row = $ranking->fetch_assoc()) {
      array_push($response, array("id" => intval($row['ID']), "name" => $row['FirstName']." " .$row['LastName'], "score" => $row['Score']));
  }
} 

$conn->close();
echo json_encode($response);
