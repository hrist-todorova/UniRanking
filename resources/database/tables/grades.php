<?php

function createTableGrades($connection) {
    $sql = "CREATE TABLE uni_ranking.grades (
	  StudentID INT UNSIGNED NOT NULL,
	  SubjectID INT UNSIGNED NOT NULL,
	  Grade FLOAT NOT NULL DEFAULT 2.00,
      PRIMARY KEY (StudentID, SubjectID),
      FOREIGN KEY (StudentID) REFERENCES students(ID),
      FOREIGN KEY (SubjectID) REFERENCES subjects(ID)
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable grades created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
}