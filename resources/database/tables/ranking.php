<?php

function createTableRanking($connection) {
    $sql = "CREATE TABLE uni_ranking.ranking (
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

    $connection->query("CREATE OR REPLACE VIEW uni_ranking.1 
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
    FROM uni_ranking.ranking rank 
    JOIN uni_ranking.students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 1 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW uni_ranking.2 
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
    FROM uni_ranking.ranking rank 
    JOIN uni_ranking.students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 2 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW uni_ranking.3
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
    FROM uni_ranking.ranking rank 
    JOIN uni_ranking.students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 3 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW uni_ranking.4
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
    FROM uni_ranking.ranking rank 
    JOIN uni_ranking.students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 4 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW uni_ranking.5
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
    FROM uni_ranking.ranking rank 
    JOIN uni_ranking.students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 5 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW uni_ranking.6
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
    FROM uni_ranking.ranking rank 
    JOIN uni_ranking.students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 6 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");

    $connection->query("CREATE OR REPLACE VIEW uni_ranking.7
    AS SELECT student.ID, student.FirstName, student.LastName, rank.Score 
    FROM uni_ranking.ranking rank 
    JOIN uni_ranking.students student 
    ON student.ID = StudentID
    WHERE SpecialityID = 7 AND IsAccepted = TRUE
    ORDER BY rank.Score DESC;");
    
}