<?php
session_start();
require_once "connection.php";
if(isset($_POST['next'])){
    $_SESSION['president']=$_POST['president'];
    header("Location:vicepresident.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <form method="POST" >
<h2>Select Your President</h2>
<input type="radio"name="president"value="Innocent Gabriel">
Innocent Gabriel<br><br>
<input type="radio"name="president"value="Anthony kapinga">
Anthony kapinga<br><br>
<input type="radio"name="president"value="Sarah John">
Sarah John<br><br>
<button type="submit"name="next">Next</button>
   </form>
</body>
</html>