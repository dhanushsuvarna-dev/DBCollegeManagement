<?php

$conn = new mysqli(
    "localhost",
    "root",
    "231106",
    "college_management1"
);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


?>