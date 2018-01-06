<?php

function createTableStudents($connection) {
    $sql = "CREATE TABLE uni_ranking.students (
	  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	  firstname VARCHAR(256) NOT NULL,
	  lastname VARCHAR(256) NOT NULL
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable student created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
}