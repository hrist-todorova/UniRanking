<?php

$data = json_decode(file_get_contents('php://input'), true);

require_once(realpath( "../../resources/config.php"));

$mysqli = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$names = explode(" ", $data["name"]); //check if null
$firstName = $names[0]; // check if > 256
$lastName = $names[1]; // check if > 256
$gradesArr =  $data["grades"];
$wishesArr =  $data["wishes"];


$mysqli->begin_transaction();

$stmt = $mysqli->prepare('INSERT INTO uni_ranking.students(FirstName, LastName) VALUES (?, ?);');
if(!$stmt) {
    $error = $mysqli->errno . ' ' . $mysqli->error;
    echo $error;
    $mysqli->rollback();
    return;
}

$stmt->bind_param("ss", $firstName, $lastName);
if(!$stmt->execute()){
    print_r("Error : $mysqli->error");
    $mysqli->rollback();
    return;
}

$studentID = $mysqli->insert_id;

$grades = array();

foreach ($gradesArr as $index => $values) {
    $grade =  $values["grade"]; //check if null
    $subjectID = $values["subjectId"]; //check if null

    $grades[$subjectID] = $grade;
}

if(!$stmt) {
    $error = $mysqli->errno . ' ' . $mysqli->error;
    echo $error;
    $mysqli->rollback();
    return;
}

foreach ($wishesArr as $index => $values) {
    $priority =  $values["priority"]; //check if null
    $specialityId = $values["specialityId"]; //check if null
   
    switch($specialityId) {
        case 1:
            break;
        case 2:
            break;
        case 3:
            break;
        case 4:
            break;
        case 5:
            break;
        case 6:
            break;
        case 7:
            break;
    }

    if(!$stmt->execute()){
        print_r("Error : $mysqli->error");
        $mysqli->rollback();
        return;
    }
}

$mysqli->commit();

function mathematicsTypeScore($grades) {

    $matdp = (empty($grades[3])) ? 0 : $grades[3];
    $mat1ex = (empty($grades[4])) ? 0 : $grades[4];
    $mat2ex = (empty($grades[5])) ? 0 : $grades[5];
    $matmt = (empty($grades[6])) ? 0 : $grades[6];
    
    if($matmt != 0) {
        $matdp = $matmt;
    }
    
    return $matdp + 3*max($mat1ex, $mat2ex, $matmt);
}
  
function informaticsTypeScore($grades) {

    $matdp = (empty($grades[3])) ? 0 : $grades[3];
    $mat1ex = (empty($grades[4])) ? 0 : $grades[4];
    $mat2ex = (empty($grades[5])) ? 0 : $grades[5];
    $matmt = (empty($grades[6])) ? 0 : $grades[6];
  
    if($matmt != 0) {
        $matdp = $matmt;
    }
    
    return $matdp + max(3*$mat1ex, 2*$mat2ex, 2*$matmt);
}