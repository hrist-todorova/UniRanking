<?php

function createTableRanking($connection, $database) {
    $sql = "CREATE TABLE ". $database .".ranking (
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
        echo "\nTable ranking created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }
    

    $connection->query("CREATE OR REPLACE VIEW ". $database .".1 
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score
    FROM ". $database .".ranking rank 
    JOIN ". $database .".students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 1 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW ". $database .".2 
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score
    FROM ". $database .".ranking rank 
    JOIN ". $database .".students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 2 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW ". $database .".3
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score
    FROM ". $database .".ranking rank 
    JOIN ". $database .".students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 3 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW ". $database .".4
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score
    FROM ". $database .".ranking rank 
    JOIN ". $database .".students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 4 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW ". $database .".5
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score
    FROM ". $database .".ranking rank 
    JOIN ". $database .".students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 5 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW ". $database .".6
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score
    FROM ". $database .".ranking rank 
    JOIN ". $database .".students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 6 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW ". $database .".7
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score
    FROM ". $database .".ranking rank 
    JOIN ". $database .".students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 7 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");
}