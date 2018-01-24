<?php

if(false){
  http_response_code(401);
  header('Content-type: application/json');
  echo json_encode(array("error" => "Authentication failed"));
}else {
  http_response_code(200);
  echo json_encode(array("name" => "admin", "isAdmin" => true));
}

