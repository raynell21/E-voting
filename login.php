<?php
session_start();
//initial message
$message="";
require_once "connection.php";



if($_SERVER['REQUEST_METHOD']==='POST'){
    $_nid=$_POST['nid']?? '';
    $_phone=$_POST['phone']?? '';

if(empty($nid)||empty($phone)){
    $message="All fields are required";
}else{
    //prepared statements(secure)
    $stmt=$conn->prepare(
        "SELECT * FROM students WHERE nid = ?AND phone = ?"
    );$stmt->bind_param("ss",$nid,$phone);
    $stmt->execute();
    $result=$stmt->get_result();

    if($result->num_rows === 1){
        $message="Login successful";
    }else{
        $message="Invalid nid OR phone";
    }
}

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Voter Login</title>
<link rel="stylesheet" href="style.css"></link>
</head>

<body>

<div class="login-container">
<h1>Voter Login</h1>
<p class="subtitle">Enter your National ID and Phone Number to continue</p>

<?php echo $message; ?>

<form method="POST">
    <label>Student ID</label>
    <input type="text" name="nid" placeholder="Enter your National ID" required>

    <label>Phone Number</label>
    <input type="text" name="phone" placeholder="Enter your phone number" required>

    <button class="btn-primary">Continue</button>
</form>

<button class="btn-outline">🛡 Admin Access.</button>
<button class="btn-outline">🛡 Observer Access</button>

</div>
</body>
</html>
