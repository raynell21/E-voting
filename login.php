<?php
session_start();
require_once "connection.php";

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nid   = trim($_POST['nid'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // 1. Check empty fields
    if ($nid === '' || $phone === '') {
        $message = "All fields are required";
    } 
    // 2. Check database
    else {
        $stmt = $conn->prepare(
            "SELECT 1 FROM students WHERE nid = ? AND phone = ?"
        );
        $stmt->bind_param("ss", $nid, $phone);
        $stmt->execute();
        $stmt->store_result();

        // 3. Check result
        if ($stmt->num_rows === 1) {
            $message = "Login successful";
        } else {
            $message = "Invalid NID or phone";
        }
    }
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Voter Login</title>


<link rel="stylesheet" href="style.css">

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
