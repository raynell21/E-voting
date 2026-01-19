<?php
$servername="localhost";
$username="root";
$password="";
$database="";
//create connection
$conn=new mysqli("localhost","root","","");
//check connection
if($conn->connect_error){
    die("database connection failed");
}
?>