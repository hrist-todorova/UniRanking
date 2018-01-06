<?php


function createTableSpeciality($connection) {
    $sql = "CREATE TABLE uni_ranking.speciality (
	  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	  name VARCHAR(256) NOT NULL,
      	  ordered_tuition INT NOT NULL DEFAULT 0,
	  paid_tuition INT NOT NULL DEFAULT 0
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable speciality created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
}
