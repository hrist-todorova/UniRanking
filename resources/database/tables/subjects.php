<?php

function createTableSubjects($connection) {
    $sql = "CREATE TABLE uni_ranking.subjects (
	  ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	  Name VARCHAR(255) NOT NULL UNIQUE,
      Alias VARCHAR(10) NOT NULL UNIQUE
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable subjects created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }

    # ДАННИТЕ СА ОТ КСК СУ 2016

    $connection->begin_transaction();

    $connection->query("SET NAMES utf8;");

    $sql = "INSERT INTO uni_ranking.subjects(Name, Alias)
    VALUES 
        ('БЕЛ - диплома', 'beldp'),
        ('БЕЛ - изпит', 'belex'),
        ('Математика - диплома', 'matdp'),
        ('Математика I- изпит', 'mat1ex'),
        ('Математика II- изпит', 'mat2ex'),
        ('Математика - матура', 'matmt')
    ;";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable subjects is now full.";
        $connection->commit();
    } else {
        echo "\nError populating table subjects: " . $connection->error;
        $connection->rollback();
    }
}