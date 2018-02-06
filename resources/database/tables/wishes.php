<?php

function createTableWishes($connection, $database) {
    $sql = "CREATE TABLE ". $database .".wishes (
      ID INT UNSIGNED AUTO_INCREMENT UNIQUE,
      StudentID INT UNSIGNED NOT NULL,
      SpecialityID INT UNSIGNED NOT NULL,
      Score FLOAT NULL,
      Priority INT UNSIGNED NOT NULL,
      PRIMARY KEY (StudentID, SpecialityID, Priority),
      FOREIGN KEY (StudentID) REFERENCES students(ID),
      FOREIGN KEY (SpecialityID) REFERENCES speciality(ID)
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable wishes created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
}