<?php

function createTableStudents($connection) {
    $sql = "CREATE TABLE uni_ranking.students (
	  ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	  Firstname VARCHAR(255) NOT NULL,
	  Lastname VARCHAR(255) NOT NULL,
      IsMale BOOL NULL
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable students created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
}