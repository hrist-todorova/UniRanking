<?php

$specialityId = $_GET['specialityId'];

require_once(realpath( "../../resources/config.php"));

$conn = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);
if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

$conn->set_charset("utf8");
$response = array();

$ranking = $conn->query("SELECT * FROM ". $config["db"]["name"] ."." . $specialityId);

if ($ranking->num_rows > 0) {
    while($row = $ranking->fetch_assoc()) {
        array_push($response, array("id" => intval($row['ID']), "name" => $row['FirstName']." " .$row['LastName'], "score" => $row['Score'], "isPaidTuition" => false));
    }
} 

$paid = $conn->query("SELECT Paid_tuition_men, Paid_tuition_women FROM ". $config["db"]["name"] .".speciality WHERE ID = ". $specialityId);
$row = $paid->fetch_assoc();
$paid_men = $conn->query("SELECT * FROM ". $config["db"]["name"] .".wishes w JOIN ". $config["db"]["name"] .".students s ON w.StudentID = s.ID WHERE w.SpecialityID = ". $specialityId ." AND w.isPaidTuition = 1 AND s.isMale = TRUE ORDER BY w.Score DESC LIMIT " . $row["Paid_tuition_men"]);
$paid_women = $conn->query("SELECT * FROM ". $config["db"]["name"] .".wishes w JOIN ". $config["db"]["name"] .".students s ON w.StudentID = s.ID WHERE w.SpecialityID = ". $specialityId ." AND w.isPaidTuition = 1 AND s.isMale = FALSE ORDER BY w.Score DESC LIMIT " . $row["Paid_tuition_women"]);

if ($paid_men->num_rows > 0) {
    while($row = $paid_men->fetch_assoc()) {
        array_push($response, array("id" => intval($row['ID']), "name" => $row['Firstname']." " .$row['Lastname'], "score" => $row['Score'], "isPaidTuition" => true));
    }
} 

if ($paid_women->num_rows > 0) {
    while($row = $paid_women->fetch_assoc()) {
        array_push($response, array("id" => intval($row['ID']), "name" => $row['Firstname']." " .$row['Lastname'], "score" => $row['Score'], "isPaidTuition" => true));
    }
} 

$conn->close();

echo json_encode($response);