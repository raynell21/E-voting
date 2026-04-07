<?php
session_start();
require_once "connection.php";

// Check if user is logged in and has selected president
if (!isset($_SESSION['student_id']) || !isset($_SESSION['president'])) {
    header("Location: login.php");
    exit();
}

// NEXT → Secretary
if (isset($_POST['next'])) {
    if (empty($_POST['vice_president'])) {
        $error = "Please select a candidate";
    } else {
        $_SESSION['vice_president'] = $_POST['vice_president'];
        header("Location: secretary.php");
        exit();
    }
}

// BACK → President
if (isset($_POST['back'])) {
    header("Location: president.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote for Vice President</title>
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

      <div class="step active">
        <span class="circle">2</span>
        <span class="label">Vice President</span>
      </div>

      <div class="line"></div>

      <div class="step">
        <span class="circle">3</span>
        <span class="label">Secretary</span>
      </div>
    </div>

    <section class="first">
        <h1>Vice President</h1>
        <div class="choice">
           <h2>Select your choice of Vice President</h2>
           <span>Step 2 of 3</span>
        </div>
        <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    </section>

    <form method="POST">
        <section class="cards">
            <div class="card" onclick="selectCard(this)">
                <img src="images/sarah.jpeg" alt="Sarah Johnson">
                <div>
                    <h2>Sarah Johnson</h2>
                    <h3>Progressive Alliance</h3>
                    <p>Experienced leader with 15 years in community development</p>
                </div>
                <button type="button" class="select-btn">Select</button>
            </div>

            <div class="card" onclick="selectCard(this)">
                <img src="images/sarah.jpeg" alt="Michael Chien">
                <div>
                    <h2>Michael Chien</h2>
                    <h3>Unit Party</h3>
                    <p>Innovative thinker focused on sustainable growth</p>
                </div>
                <button type="button" class="select-btn">Select</button>
            </div>

            <div class="card" onclick="selectCard(this)">
                <img src="images/sarah.jpeg" alt="Emily Rodriguez">
                <div>
                    <h2>Emily Rodriguez</h2>
                    <h3>Democratic Front</h3>
                    <p>Advocate for education and youth programs</p>
                </div>
                <button type="button" class="select-btn">Select</button>
            </div>
        </section>

        <div class="exit">
            <button type="submit" name="next">Next</button>
        </div>

        <div class="back">
            <button type="submit" name="back">Back</button>
        </div>

        <input type="hidden" name="vice_president" id="selectedVicePresident">
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

    // save selection
    document.getElementById('selectedVicePresident').value = card.querySelector('h2').innerText;
}
</script>

</body>
</html>