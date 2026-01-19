<?php


$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nid = $_POST['nid'];
    $phone = $_POST['phone'];

    if ($nid == $correct_nid && $phone == $correct_phone) {
        $message = "<h2 style='color:green;text-align:center'>Login Successful ✔</h2>";
    } else {
        $message = "<h2 style='color:red;text-align:center'>Invalid National ID or Phone ❌</h2>";
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
