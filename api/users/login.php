<?php
$body = json_decode(file_get_contents('php://input'), true);

if($body['username'] == 'admin' && $body['password'] == '12345'){
  http_response_code(200);
  echo json_encode(array("name" => "admin", "isAdmin" => true));
}else {
  http_response_code(401);
  header('Content-type: application/json');
  echo json_encode(array("error" => "Authentication failed"));
}

