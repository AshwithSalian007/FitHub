<?php
// Database credentials
$db_servername = "localhost";
$db_username = "root";
$db_password = "mysql";
$db_database = "fithub";

// Create connection
$conn = new mysqli($db_servername, $db_username, $db_password, $db_database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
