<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "e_voting"; // <-- set your database name here

//create connection
$conn = new mysqli($servername, $username, $password, $database);

//check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>