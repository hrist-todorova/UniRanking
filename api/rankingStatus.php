<?php 

header("Content-type: application/json");
echo json_encode(array("hasChanges" => true));


var_dump($_GET);