<?php
session_start();
require_once "connection.php";

$message = "";
$nid_value = '';
$phone_value = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nid   = trim($_POST['nid'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        $nid_value = htmlspecialchars($nid, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $phone_value = htmlspecialchars($phone, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

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
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Voter Login</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body>

<main class="page-bg">
    <section class="card login-card">
        <div class="brand">
            <h1>Voter Portal</h1>
            <p class="subtitle">Enter your National ID and Phone Number to continue</p>
        </div>

        <?php
            $messageClass = '';
            if ($message !== '') {
                    if (strpos(strtolower($message), 'successful') !== false) {
                            $messageClass = 'message-success';
                    } else {
                            $messageClass = 'message-error';
                    }
            }
        ?>

        <?php if ($message !== ''): ?>
            <div class="message <?php echo $messageClass; ?>">
                <?php echo htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="login-form" novalidate>
            <label for="nid">Student ID</label>
            <input id="nid" name="nid" type="text" placeholder="e.g. 12345678" value="<?php echo $nid_value; ?>" required>

            <label for="phone">Phone Number</label>
            <input id="phone" name="phone" type="tel" placeholder="e.g. +254700000000" value="<?php echo $phone_value; ?>" required>

            <button type="submit" class="btn btn-primary">Continue</button>
        </form>

        <div class="secondary-actions">
            <a class="btn btn-outline" href="#">🛡 Admin Access</a>
            <a class="btn btn-outline" href="#">🛡 Observer Access</a>
        </div>

        <footer class="card-footer">Need help? Contact your election admin.</footer>
    </section>
</main>

</body>
</html>
