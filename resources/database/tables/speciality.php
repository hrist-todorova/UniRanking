<?php


function createTableSpeciality($connection) {
    $sql = "CREATE TABLE uni_ranking.speciality (
      ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
      Name VARCHAR(256) NOT NULL,
      Ordered_tuition INT NOT NULL DEFAULT 0,
      Paid_tuition INT NOT NULL DEFAULT 0
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable speciality created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
}
