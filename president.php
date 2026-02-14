<?php
session_start();
require_once "connection.php";
if(isset($_POST['Next'])){
    $_SESSION['president']=$_POST['president'];
    header("Location:vice_president.php");
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
       <button type="button">Step 1 of 3</button>
    </div>
   </section>

   <form method="POST">
   <section class="cards">
    <div class="card" onclick="selectCard(this)">

        <img src="images/sarah.jpeg">
        <div>
            <h2>Sarah Johnson</h2><br>
            <h3>Progressive Alliance</h3>
            <p>Experienced leader with 15<br> years in community development</p>
             
        </div>
         
        <div>
         <button type="button" class="select-btn">Select</button>

            
        </div>
        

    </div>
    
    <div class="card" onclick="selectCard(this)">

        <img src="images/sarah.jpeg">
        <div>
            <h2>Michael Chien</h2><br>
            <h3>Unit Party</h3>
            <p>Innovative thinker focused on<br>sustainable growth</p>
             
        </div>

        <div>
            <button type="button" class="select-btn">Select</button>

        </div>

    </div>
<div class="card" onclick="selectCard(this)">


        <img src="images/sarah.jpeg">
        <div>
            <h2>Emily Rodriguez</h2><br>
            <h3>Democratic Front</h3>
            <p>Advocate for education and youth programm<br>sustainable growth</p>
             
        </div>
        <div>
           <button type="button" class="select-btn">Select</button>

        </div>

<script>
function selectCard(card) {

  document.querySelectorAll('.card').forEach(c => {
    c.classList.remove('selected');
    c.querySelector('.select-btn').innerText = 'Select';
  });

  card.classList.add('selected');
  card.querySelector('.select-btn').innerText = 'Selected ✔';

  // store selected president name
  document.getElementById('selectedPresident').value =
    card.querySelector('h2').innerText;
}
</script>


    </div>

   </section>
   <div class="exit">
     
     <button type="submit" name="Next">Next</button>

     
   </div>
 </div>
 <input type="hidden" name="president" id="selectedPresident">

</form>
</body>
</html>