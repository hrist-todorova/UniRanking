<?php

$allGrades = array("d1", "m1", "m2", "d2");
$grades = array("d1" => 5.5, "m1" => 6, "m2" => 5);
$formula = "return max(3*m2 + d1, 2*m1 + d1, 2*d2 + d1);";

foreach($allGrades as $alias){
  if(!isset($grades[$alias])){
    $grades[$alias] = 0;
  }
}

foreach($grades as $key => $value){
  $formula = str_replace($key, (string)$value, $formula);
}

echo "<h3>" . $formula . "</h3>";
echo "<h3>" . eval($formula) . "</h3>";