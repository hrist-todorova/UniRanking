<?php

$body = json_decode(file_get_contents('php://input'), true);

require_once(realpath( "../resources/config.php"));
require_once (realpath("transactions.php"));

$mysqli = new mysqli($config["db"]["host"], $config["db"]["username"], $config["db"]["password"]);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

addStudent($body, $mysqli);
