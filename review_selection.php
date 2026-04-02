<?php 
session_start();
require_once "connection.php";

// Check if user has made all selections
if (!isset($_SESSION['student_id']) || 
    !isset($_SESSION['president']) || 
    !isset($_SESSION['vice_president']) || 
    !isset($_SESSION['secretary'])) {
    header("Location: login.php");
    exit();
}

$error = '';

// Back to secretary
if(isset($_POST['back'])){
    header("Location: secretary.php");
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
        <p>Once you submit your vote, it cannot be changed. Please ensure all your selections are correct before proceeding</p>
    </div>
    <div class="selections">
        <div class="selection-item">
            <label>President:</label>
            <span><?php echo htmlspecialchars($_SESSION['president'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
        </div>
        <div class="selection-item">
            <label>Vice President:</label>
            <span><?php echo htmlspecialchars($_SESSION['vice_president'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
        </div>
        <div class="selection-item">
            <label>Secretary:</label>
            <span><?php echo htmlspecialchars($_SESSION['secretary'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
        </div>
    </div>
 </div>
    </section>
    <form method="POST" action="submit.php">
        <button type="submit" name="submit_vote" class="btn btn-primary">Submit Vote</button>
        <button type="submit" name="back" class="btn btn-secondary">Back</button>
    </form>
</body>
</html>