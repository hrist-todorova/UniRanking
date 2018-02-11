<?php

require_once(realpath( "../config.php"));

$dirPath = './tables/';
$fileList = array(
    'student.php',
    'speciality.php',
    'wishes.php',
    'subjects.php',
    'ranking.php'
);

foreach($fileList as $fileName)
{
    include_once($dirPath.$fileName);
}

$mysqli = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

createTableStudents($mysqli, $config["db"]["name"]);
createTableSpeciality($mysqli, $config["db"]["name"]);
createTableSubjects($mysqli, $config["db"]["name"]);
createTableWishes($mysqli, $config["db"]["name"]);
createTableRanking($mysqli, $config["db"]["name"]);

$mysqli->close();