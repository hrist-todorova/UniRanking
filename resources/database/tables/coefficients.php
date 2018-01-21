<?php


function createTableCoefficients($connection) {
    $sql = "CREATE TABLE uni_ranking.coeff (
      SpecialityID INT UNSIGNED NOT NULL,
	  SubjectID INT UNSIGNED NOT NULL,
      Coefficient FLOAT NOT NULL,
      PRIMARY KEY (SpecialityID, SubjectID),
      FOREIGN KEY (SpecialityID) REFERENCES speciality(ID),
      FOREIGN KEY (SubjectID) REFERENCES subjects(ID)
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable coeff created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
}