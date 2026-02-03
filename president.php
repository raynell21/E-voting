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
    <link rel="stylesheet"href="style.css">
</head>
<body>
 <div class="president">
     <div class="steps">
       <div class="step active">
        <span class="circle">1</span>
        <span class="label">President</span>
       </div>

       <div class="line"></div>

       <div class="step">
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
    <h1>President</h1>
    <div class="choice">
       <h2>Select your choice of President</h2>
       <button type="submit"name="next">Step 1 of 3</button>
    </div>
   </section>

   
   <section class="cards">
    <div class="card" onclick="selectCard(this)">
        <img src="images/sarah.jpeg">
        <div>
            <h2>Sarah Johnson</h2><br>
            <h3>Progressive Alliance</h3>
            <p>Experienced leader with 15<br> years in community development</p>
             
        </div>
         
        <div>
         <button type="submit"name="next"class="select-btn">Selected</button>
            
        </div>
        

    </div>
    
    <div class="card"onclick="selectCard(this)">
        <img src="images/sarah.jpeg">
        <div>
            <h2>Michael Chien</h2><br>
            <h3>Unit Party</h3>
            <p>Innovative thinker focused on<br>sustainable growth</p>
             
        </div>

        <div>
            <button type="submit"name="next"class="select-btn">Selected</button>
        </div>

    </div>
     <div class="card"onclick="selectCard(this)">
        <img src="images/sarah.jpeg">
        <div>
            <h2>Emily Rodriguez</h2><br>
            <h3>Democratic Front</h3>
            <p>Advocate for education and youth programm<br>sustainable growth</p>
             
        </div>
        <div>
            <button type="submit"name="next"class="select-btn">Selected</button>
        </div>
<script>
function selectCard(card) {

  // remove selected from all cards
  document.querySelectorAll('.card').forEach(c => {
    c.classList.remove('selected');
    c.querySelector('.select-btn').innerText = 'Select';
  });

  // select clicked card
  card.classList.add('selected');
  card.querySelector('.select-btn').innerText = 'Selected ✔';

  // store selected value
  document.getElementById('selectedCard').value = card.dataset.value;

  // enable next button
  document.getElementById('nextBtn').disabled = false;
}
</script>

    </div>

   </section>
   <div class="exit">
     <a href="vice_president.php">
     <button type="submit">Next</button>
     </a>
   </div>
 </div>
</body>
</html>