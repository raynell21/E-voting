<?php
session_start();
require_once "connection.php";

// Check if user is logged in and has selected previous positions
if (!isset($_SESSION['student_id']) || !isset($_SESSION['president']) || !isset($_SESSION['vice_president'])) {
    header("Location: login.php");
    exit();
}

// REVIEW → review_selection.php
if (isset($_POST['review'])) {
    if (empty($_POST['secretary'])) {
        $error = "Please select a candidate";
    } else {
        $_SESSION['secretary'] = $_POST['secretary'];
        header("Location: review_selection.php");
        exit();
    }
}

// BACK → Vice President
if (isset($_POST['back'])) {
    header("Location: vice_president.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote for Secretary</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="president">
    <div class="steps">
      <div class="step">
        <span class="circle">1</span>
        <span class="label">President</span>
      </div>

      <div class="line"></div>

      <div class="step">
        <span class="circle">2</span>
        <span class="label">Vice President</span>
      </div>

      <div class="line"></div>

      <div class="step active">
        <span class="circle">3</span>
        <span class="label">Secretary</span>
      </div>
    </div>

    <section class="first">
        <h1>Secretary</h1>
        <div class="choice">
           <h2>Select your choice of Secretary</h2>
           <span>Step 3 of 3</span>
        </div>
        <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    </section>

    <form method="POST">
        <section class="cards">
            <div class="card" onclick="selectCard(this)">
                <img src="images/sarah.jpeg.jpg" alt="Sarah Johnson, Progressive Alliance candidate for Secretary, smiling portrait photo">
                <div>
                    <h2>Sarah Johnson</h2>
                    <h3>Progressive Alliance</h3>
                    <p>Experienced leader with 15 years in community development</p>
                </div>
                <button type="button" class="select-btn">Select</button>
            </div>

            <div class="card" onclick="selectCard(this)">
                <img src="images/michael.jpeg.jpg" alt="Michael Chien, Unit Party candidate for Secretary, smiling portrait photo">
                <div>
                    <h2>Michael Chien</h2>
                    <h3>Unit Party</h3>
                    <p>Innovative thinker focused on sustainable growth</p>
                </div>
                <button type="button" class="select-btn">Select</button>
            </div>

            <div class="card" onclick="selectCard(this)">
                <img src="images/emily.jpeg.jpg" alt="Emily Rodriguez, Democratic Front candidate for Secretary, smiling portrait photo">
                <div>
                    <h2>Emily Rodriguez</h2>
                    <h3>Democratic Front</h3>
                    <p>Advocate for education and youth programs</p>
                </div>
                <button type="button" class="select-btn">Select</button>
            </div>
        </section>

        <div class="back">
            <button type="submit" name="back">Back</button>
        </div>

        <div class="review">
            <button type="submit" name="review">Review selections</button>
        </div>

        <input type="hidden" name="secretary" id="selectedSecretary">
    </form>
</div>

<script>
function selectCard(card) {
    document.querySelectorAll('.card').forEach(c => {
        c.classList.remove('selected');
        c.querySelector('.select-btn').innerText = 'Select';
    });

    card.classList.add('selected');
    card.querySelector('.select-btn').innerText = 'Selected ✔';

    // save secretary
    document.getElementById('selectedSecretary').value = card.querySelector('h2').innerText;
}
</script>

</body>
</html>