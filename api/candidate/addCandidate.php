<?php

$data = json_decode(file_get_contents('php://input'), true);

require_once(realpath( "../../resources/config.php"));
require_once(realpath("./executeRanking.php"));

$mysqli = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$names = explode(" ", $data["name"]); //check if null
$firstName = $names[0]; // check if > 256
$lastName = $names[1]; // check if > 256
$gradesArr =  $data["grades"];
$wishesArr =  $data["wishes"];
$isMale = $data["isMale"];


$mysqli->begin_transaction();

$stmt_wishes = $mysqli->prepare('INSERT INTO uni_ranking.students(FirstName, LastName, IsMale) VALUES (?, ?, ?);');
if(!$stmt_wishes) {
    $error = $mysqli->errno . ' ' . $mysqli->error;
    echo $error;
    $mysqli->rollback();
    return;
}

$stmt_wishes->bind_param("ssi", $firstName, $lastName, $isMale);
if(!$stmt_wishes->execute()){
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

$stmt_wishes = $mysqli->prepare('INSERT INTO uni_ranking.wishes(StudentID, SpecialityID, Priority, Score) VALUES (?, ?, ?, ?);');
if(!$stmt_wishes) {
    $error = $mysqli->errno . ' ' . $mysqli->error;
    echo $error;
    $mysqli->rollback();
    return;
}

$stmt_ranking = $mysqli->prepare('INSERT INTO uni_ranking.ranking(ID, StudentID, SpecialityID, Score, IsMale) VALUES (?, ?, ?, ?, ?);');
if(!$stmt_ranking) {
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

    $stmt_wishes->bind_param("iiii", $studentID, $specialityId, $priority, $score);
    if(!$stmt_wishes->execute()){
        print_r("Error : $mysqli->error");
        $mysqli->rollback();
        return;
    }

    if($priority == 1) {
        $first_wish_id = $mysqli->insert_id;
        $stmt_ranking->bind_param("iiiii", $first_wish_id, $studentID, $specialityId, $score, $isMale);
        if(!$stmt_ranking->execute()){
            print_r("Error : $mysqli->error");
            $mysqli->rollback();
            return;
        }
    }

    executeRanking($mysqli, $isMale);
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