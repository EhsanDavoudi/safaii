<?php

$servername = "safaa-samimiat.db";
$username = "root";
$password = "root";
$dbname = "safaa-samimiat";

$conn = new \mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
