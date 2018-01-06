<?php


function addStudent($data, $mysqli) {
    $names = explode(" ", $data["name"]); //check if null
    $firstName = $names[0]; // check if > 256
    $lastName = $names[1]; // check if > 256

    $mysqli->begin_transaction();

    $stmt = $mysqli->prepare('INSERT INTO uni_ranking.students(FirstName, LastName) VALUES (?, ?);');
    if($stmt) {
        $stmt->bind_param("ss", $firstName, $lastName);
        if(!$stmt->execute()){
            print_r("Error : $mysqli->error");
            $mysqli->rollback();
            return;
        }
        if(addGrades($mysqli->insert_id, $data["grades"], $mysqli) == false) {
            $mysqli->rollback();
            return;
        } else {
            $mysqli->commit();
        }
    } else {
        $error = $mysqli->errno . ' ' . $mysqli->error;
        echo $error;
        $mysqli->rollback();
        return;
    }

}

function addGrades($studentID, $gradesArr, $mysqli) {

    $stmt = $mysqli->prepare('INSERT INTO uni_ranking.grades(StudentID, SubjectID, Grade) VALUES (?, ?, ?);');
    if($stmt) {
        foreach ($gradesArr as $index => $values) {
            $grade =  $values["grade"]; //check if null
            $subjectID = $values["subjectId"]; //check if null

            $stmt->bind_param("iii", $studentID, $subjectID, $grade);
            if(!$stmt->execute()){
                print_r("Error : $mysqli->error");
                $mysqli->rollback();
                return false;
            }
        }
    } else {
        $error = $mysqli->errno . ' ' . $mysqli->error;
        echo $error;
        $mysqli->rollback();
        return false;
    }
    return true;
}