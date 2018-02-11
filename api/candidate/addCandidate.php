<?php

$data = json_decode(file_get_contents('php://input'), true);

require_once(realpath( "../../resources/config.php"));
require_once(realpath("./executeRanking.php"));

$mysqli = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$errors = array();

$mysqli->set_charset("utf8");

if(isset($data["name"])) {
    $names = explode(" ", $data["name"]);

    $firstName = $names[0];
    if(!isset($names[1])) {
        array_push($errors, "Липсва фамилия.");
        http_response_code(422);
        echo json_encode($errors);
        return;
    }
    $lastName = $names[1];
    if(strlen($names[0]) > 256 || strlen($names[1]) > 256) {
        array_push($errors, "Името или фамилията са твърде дълги.");
        http_response_code(422);
        echo json_encode($errors);
        return;
    }
   
} else {
    array_push($errors, "Липсват име и фамилия.");
    http_response_code(422);
    echo json_encode($errors);
    return;
}

$gradesArr =  $data["grades"];
if(sizeof($gradesArr) == 0) {
    array_push($errors, "Няма въведени оценки.");
}
$wishesArr =  $data["wishes"];
if(sizeof($wishesArr) == 0) {
    array_push($errors, "Няма въведени желания.");
}
$isMale = $data["isMale"];
if(!isset($data["isMale"])) {
    array_push($errors, "Няма зададен пол.");
}

if(sizeof($errors) > 0) {
    http_response_code(422);
    echo json_encode($errors);
    return;
}

$grades = array();

foreach ($gradesArr as $index => $values) {
    $grade =  $values["grade"]; 
    if($grade > 6 || $grade < 2) {
        array_push($errors, "Има невалидна оценка.");
        http_response_code(422);
        echo json_encode($errors);
        return;
    }
    $subjectID = $values["subjectId"];

    $grades[$subjectID] = $grade;
}


$mysqli->begin_transaction();

$stmt_wishes = $mysqli->prepare('INSERT INTO '. $config["db"]["name"] .'.students(FirstName, LastName, IsMale) VALUES (?, ?, ?);');
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

$stmt_wishes = $mysqli->prepare('INSERT INTO '. $config["db"]["name"] .'.wishes(StudentID, SpecialityID, Priority, Score, isPaidTuition) VALUES (?, ?, ?, ?, ?);');
if(!$stmt_wishes) {
    $error = $mysqli->errno . ' ' . $mysqli->error;
    echo $error;
    $mysqli->rollback();
    return;
}

$stmt_ranking = $mysqli->prepare('INSERT INTO '. $config["db"]["name"] .'.ranking(ID, StudentID, SpecialityID, Score, IsMale) VALUES (?, ?, ?, ?, ?);');
if(!$stmt_ranking) {
    $error = $mysqli->errno . ' ' . $mysqli->error;
    echo $error;
    $mysqli->rollback();
    return;
}

foreach ($wishesArr as $index => $values) {
    $priority =  $values["priority"];
    $specialityId = $values["specialityId"];
    $isPaidTuition = $values["isPaidTuition"];

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

    $stmt_wishes->bind_param("iiiii", $studentID, $specialityId, $priority, $score, $isPaidTuition);
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

    executeRanking($mysqli, $isMale, $config["db"]["name"]);
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