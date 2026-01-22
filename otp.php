<?php

require_once "connection.php";



?>
<!DOCTYPE html>
<html>
<head>
<title>OTP Verification</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
<h2>Verify OTP</h2>
<p>We've sent a 6-digit code to 123****890</p>

<form method="POST">
    <input type="text" name="verify_otp" placeholder="Verify OTP" required>
   <p>Resend OTP</p>
    <input type="text" name="back" placeholder="Back to Login" required>
</form>


</div>

</body>
</html>

