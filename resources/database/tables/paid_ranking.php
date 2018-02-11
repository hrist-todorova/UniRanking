<?php

function createTablePaidRanking($connection, $database) {
    $sql = "CREATE TABLE ". $database .".paid_ranking (
      ID INT UNSIGNED,
      StudentID INT UNSIGNED NOT NULL,
      SpecialityID INT UNSIGNED NOT NULL,
      IsMale BOOL NULL,
      Score FLOAT NULL,
      IsAccepted BOOL NULL,
      PRIMARY KEY (StudentID),
      FOREIGN KEY (ID) REFERENCES wishes(ID),
      FOREIGN KEY (StudentID) REFERENCES students(ID),
      FOREIGN KEY (SpecialityID) REFERENCES speciality(ID)
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable paid_ranking created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
    
}