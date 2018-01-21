<?php

function createTableSubjects($connection) {
    $sql = "CREATE TABLE uni_ranking.subjects (
	  ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	  Name VARCHAR(256) NOT NULL
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable subjects created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
}