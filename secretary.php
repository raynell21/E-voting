<?php
session_start();
require_once"connection.php";
if(isset($_POST['next'])){
    $_SESSION['secretary']=$_POST['secretary'];
    ("location:president.php");
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
 

</body>
</html>