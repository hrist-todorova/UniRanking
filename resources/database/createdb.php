<?php

require_once(realpath( "../config.php"));

$dirPath = './tables/';
$fileList = array(
    'student.php',
    'speciality.php',
    'grades.php',
    'wishes.php',
    'coefficients.php',
    'subjects.php'
);

foreach($fileList as $fileName)
{
    include_once($dirPath.$fileName);
}

$mysqli = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

createTableStudents($mysqli);
createTableSpeciality($mysqli);
createTableSubjects($mysqli);
createTableGrades($mysqli);
createTableWishes($mysqli);
createTableCoefficients($mysqli);

$mysqli->close();