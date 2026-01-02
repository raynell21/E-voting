<?php
session_start();

$nid = $_POST['nid'];
$phone = $_POST['phone'];

if($nid=="1234567890123" && $phone=="1234567890"){

    $otp = rand(100000,999999);   // Generate 6 digit OTP
    $_SESSION['otp'] = $otp;     // Save OTP temporarily
    $_SESSION['phone'] = $phone;

    // For now we just show OTP (later you can send by SMS)
    header("Location: otp.php?otp=$otp");
}else{
    echo "<h2 style='color:red;text-align:center'>Invalid Credentials</h2>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>OTP Verification</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
<h2>OTP Verification</h2>
<p>Enter the OTP sent to your phone</p>

<form action="verify.php" method="POST">
    <input type="text" name="user_otp" placeholder="Enter OTP" required>
    <button class="btn-primary">Verify</button>
</form>

<p style="color:green;margin-top:10px">
Demo OTP: <?php echo $_GET['otp']; ?>
</p>
</div>

</body>
</html>

