<?php

require_once(realpath( "../config.php"));

$dirPath = './tables/';
$fileList = array(
    'student.php',
    'speciality.php',
    'wishes.php',
    'subjects.php',
    'ranking.php',
    'paid_ranking.php'
);

foreach($fileList as $fileName)
{
    include_once($dirPath.$fileName);
}

$mysqli = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$database = $config["db"]["name"];

createTableStudents($mysqli, $database);
createTableSpeciality($mysqli, $database);
createTableSubjects($mysqli, $database);
createTableWishes($mysqli, $database);
createTableRanking($mysqli, $database);
createTablePaidRanking($mysqli, $database);

$mysqli->query("CREATE OR REPLACE VIEW ". $database .".1 
AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
FROM ". $database .".ranking rank 
JOIN ". $database .".students student 
ON student.ID = StudentID
WHERE SpecialityID = 1 AND IsAccepted = TRUE
ORDER BY rank.Score DESC;");

$mysqli->query("CREATE OR REPLACE VIEW ". $database .".2 
AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
FROM ". $database .".ranking rank 
JOIN ". $database .".students student 
ON student.ID = StudentID
WHERE SpecialityID = 2 AND IsAccepted = TRUE
ORDER BY rank.Score DESC;");

$mysqli->query("CREATE OR REPLACE VIEW ". $database .".3
AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
FROM ". $database .".ranking rank 
JOIN ". $database .".students student 
ON student.ID = StudentID
WHERE SpecialityID = 3 AND IsAccepted = TRUE
ORDER BY rank.Score DESC;");

$mysqli->query("CREATE OR REPLACE VIEW ". $database .".4
AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
FROM ". $database .".ranking rank 
JOIN ". $database .".students student 
ON student.ID = StudentID
WHERE SpecialityID = 4 AND IsAccepted = TRUE
ORDER BY rank.Score DESC;");

$mysqli->query("CREATE OR REPLACE VIEW ". $database .".5
AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
FROM ". $database .".ranking rank 
JOIN ". $database .".students student 
ON student.ID = StudentID
WHERE SpecialityID = 5 AND IsAccepted = TRUE
ORDER BY rank.Score DESC;");

$mysqli->query("CREATE OR REPLACE VIEW ". $database .".6
AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
FROM ". $database .".ranking rank 
JOIN ". $database .".students student 
ON student.ID = StudentID
WHERE SpecialityID = 6 AND IsAccepted = TRUE
ORDER BY rank.Score DESC;");

$mysqli->query("CREATE OR REPLACE VIEW ". $database .".7
AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
FROM ". $database .".ranking rank 
JOIN ". $database .".students student 
ON student.ID = StudentID
WHERE SpecialityID = 7 AND IsAccepted = TRUE
ORDER BY rank.Score DESC;");

$mysqli->close();