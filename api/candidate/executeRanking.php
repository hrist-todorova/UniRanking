<?php

function executeRanking($mysqli, $isMale, $database) {

  $result = getAllStudentsToBeRanked($mysqli, $database);

  // iterate until all students are accepted or rejected
  while ($result->num_rows > 0) {

      // for each student -> accept/reject him/her at best possible wish
      while($row = $result->fetch_assoc()) {

        $ranked_candidates = "";
        $limit = 0;

        if($isMale) {
          $ranked_candidates = "SELECT ID, StudentID, Score FROM ". $database .".ranking WHERE IsAccepted = TRUE AND IsMale = TRUE and SpecialityID = " . $row['SpecialityID'] . " ORDER BY Score ASC";
          $limit = $row['Ordered_tuition_men'];
        } else {
          $ranked_candidates = "SELECT ID, StudentID, Score FROM ". $database .".ranking WHERE IsAccepted = TRUE AND IsMale = FALSE and SpecialityID = " . $row['SpecialityID'] . " ORDER BY Score ASC";
          $limit = $row['Ordered_tuition_women'];
        }
        $candidates = $mysqli->query($ranked_candidates);
        $count = 0;
        if ($candidates->num_rows > 0) {
          $count = $candidates->num_rows;
        }

        if($count < $limit) {
          $mysqli->query("UPDATE ". $database .".ranking SET IsAccepted = TRUE WHERE StudentID = " . $row['StudentID']);
        } else {
          $last_candidate = $candidates->fetch_assoc();
          if($row['Score'] >=  $last_candidate['Score']){
            $mysqli->query("UPDATE ". $database .".ranking SET IsAccepted = TRUE WHERE StudentID = " . $row['StudentID']);

            $new_rank_state = $mysqli->query("SELECT * FROM ". $database .".wishes WHERE Priority = (SELECT Priority FROM ". $database .".wishes WHERE ID = " . $last_candidate['ID']. " ) + 1 AND StudentID = ". $last_candidate['StudentID']);
            if ($new_rank_state->num_rows > 0) {
              $mysqli->query("UPDATE ". $database .".ranking SET Score = ".$new_rank_state['Score'] ." , SpecialityID = ".$new_rank_state['SpecialityID'] ." , IsAccepted = NULL, ID = ".$new_rank_state['ID']." WHERE StudentID = " . $last_candidate['StudentID']);
            } else {
              $mysqli->query("UPDATE ". $database .".ranking SET IsAccepted = FALSE WHERE StudentID = " . $last_candidate['StudentID']);
            }
          }
          else {
            $new_rank_state = $mysqli->query("SELECT * FROM ". $database .".wishes WHERE Priority = (SELECT Priority FROM ". $database .".wishes WHERE ID = " . $row['ID']. " ) + 1 AND StudentID = ". $row['StudentID']);
            if ($new_rank_state->num_rows > 0) {
              $mysqli->query("UPDATE ". $database .".ranking SET Score = ".$new_rank_state['Score'] ." , SpecialityID = ".$new_rank_state['SpecialityID'] ." , IsAccepted = NULL, ID = ".$new_rank_state['ID']." WHERE StudentID = " . $row['StudentID']);
            } else {
              $mysqli->query("UPDATE ". $database .".ranking SET IsAccepted = FALSE WHERE StudentID = " . $row['StudentID']);
            }
          }
        }
      }

      $result = getAllStudentsToBeRanked($mysqli, $database);
  }

  return;
}


function getAllStudentsToBeRanked($mysqli, $database) {

    $sql = "SELECT * FROM ". $database .".ranking rank JOIN ". $database .".speciality spec ON rank.SpecialityID = spec.ID WHERE rank.IsAccepted IS NULL;";

    return $mysqli->query($sql);
}

function getAllAcceptedStudentForSpeciality() {

}