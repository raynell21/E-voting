<?php 
session_start();
require_once "connection.php";
//back to secretary
if(isset($_POST['review selection'])){
    $_SESSION['review_selection']=$_POST['review_selection'];
    header("location:secretary.php");
    exit();
}

//back to president
if(isset($_POST['review'])){
    header("location: secretary.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"href="style.css">
</head>
<body>
    <section>
 <div class="review-container">
    <h1>Review Your Selection</h1>
    <h3>Please review your choices before submitting your vote</h3>
    <div class="notice">
        <h>Important Notice</h>
        <p>Once you submit your vote,it caanot be changed.Please ensure all your selections are correct before proceeding</p>
    </div>
 </div>
    </section>
    <button type="submit" name="review">Review</button>
</body>
</html>