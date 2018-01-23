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

$stmt = $mysqli->prepare('INSERT INTO uni_ranking.wishes(StudentID, SpecialityID, Priority, Score) VALUES (?, ?, ?, ?);');
if(!$stmt) {
    $error = $mysqli->errno . ' ' . $mysqli->error;
    echo $error;
    $mysqli->rollback();
    return;
}

foreach ($wishesArr as $index => $values) {
    $priority =  $values["priority"]; //check if null
    $specialityId = $values["specialityId"]; //check if null
    $score = 0;
   
    switch($specialityId) {
        case 1:
            $score = informaticsTypeScore($grades);
            break;
        case 2:
            $score = informaticsTypeScore($grades);
            break;
        case 3:
            $score = informaticsTypeScore($grades);
            break;
        case 4:
            $score = informaticsTypeScore($grades);
            break;
        case 5:
            $score = mathematicsTypeScore($grades);
            break;
        case 6:
            $score = mathematicsTypeScore($grades);
            break;
        case 7:
            $score = mathematicsTypeScore($grades);
            break;
    }

    $stmt->bind_param("iiii", $studentID, $specialityId, $priority, $score);
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