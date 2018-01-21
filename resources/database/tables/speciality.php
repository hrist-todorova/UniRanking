<?php


function createTableSpeciality($connection) {
    $sql = "CREATE TABLE uni_ranking.speciality (
      ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
      Name VARCHAR(256) NOT NULL,
      Ordered_tuition_men INT NOT NULL DEFAULT 0,
      Ordered_tuition_women INT NOT NULL DEFAULT 0,
      Paid_tuition_men INT NOT NULL DEFAULT 0,
      Paid_tuition_women INT NOT NULL DEFAULT 0
    );";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable speciality created successfully";
    } else {
        echo "\nError creating table: " . $connection->error;
    }

    # ДАННИТЕ СА ОТ КСК СУ 2016

    $connection->begin_transaction();

    $connection->query("SET NAMES utf8;");

    $sql = "INSERT INTO uni_ranking.speciality(Name, Ordered_tuition_men, Ordered_tuition_women, Paid_tuition_men, Paid_tuition_women)
    VALUES 
        ('Информатика', 75, 50, 1, 1),
        ('Компютърни науки', 115, 60, 0, 0),
        ('Софтуерно инженерство', 75, 50, 1, 1),
        ('Информационни системи', 50, 35, 1, 1),
        ('Математика', 15, 6, 1, 1),
        ('Приложна математика', 30, 20, 1, 1),
        ('Статистика', 8, 13, 1, 1) 
    ;";

    if ($connection->query($sql) === TRUE) {
        echo "\nTable speciality is now full.";
        $connection->commit();
    } else {
        echo "\nError populating table speciality: " . $connection->error;
        $connection->rollback();
    }
}
