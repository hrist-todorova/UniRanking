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

$stmt = $mysqli->prepare('INSERT INTO uni_ranking.grades(StudentID, SubjectID, Grade) VALUES (?, ?, ?);');
if(!$stmt) {
    $error = $mysqli->errno . ' ' . $mysqli->error;
    echo $error;
    $mysqli->rollback();
    return;
}

foreach ($gradesArr as $index => $values) {
    $grade =  $values["grade"]; //check if null
    $subjectID = $values["subjectId"]; //check if null

    $stmt->bind_param("iii", $studentID, $subjectID, $grade);
    if(!$stmt->execute()){
        print_r("Error : $mysqli->error");
        $mysqli->rollback();
        return;
    }
}

$mysqli->commit();