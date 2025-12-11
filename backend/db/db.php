<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "yogyalife";

$db = mysqli_connect($hostname, $username, $password, $database_name);

if ($db->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
};
?>