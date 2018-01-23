<?php

function createTableRanking($connection) {
    $sql = "CREATE TABLE uni_ranking.ranking (
      ID INT UNSIGNED AUTO_INCREMENT UNIQUE,
      StudentID INT UNSIGNED NOT NULL,
      SpecialityID INT UNSIGNED NOT NULL,
      PRIMARY KEY (StudentID),
      FOREIGN KEY (StudentID) REFERENCES students(ID),
      FOREIGN KEY (SpecialityID) REFERENCES speciality(ID)
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable ranking created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
}
