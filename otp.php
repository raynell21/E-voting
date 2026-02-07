<?php
session_start();
require_once "connection.php";

$message = '';
$masked = '123****890';
if (!empty($_SESSION['phone'])) {
        $phone = preg_replace('/\D+/', '', $_SESSION['phone']);
        if (strlen($phone) >= 6) {
                $masked = substr($phone, 0, 3) . '****' . substr($phone, -3);
        } else {
                $masked = preg_replace('/.(?=.{2})/', '*', $phone);
        }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $otp = trim($_POST['verify_otp'] ?? '');
        if ($otp === '') {
                $message = 'Please enter the 6-digit code';
        } else {
                // Placeholder for OTP verification logic
                $message = 'Verifying...';
        }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>OTP Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="page-bg">
    <section class="card login-card">
        <div class="brand">
            <h1>OTP Verification</h1>
            <p class="subtitle">We've sent a 6‑digit code to <strong><?php echo htmlspecialchars($masked, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></strong></p>
        </div>

        <?php if ($message !== ''): ?>
            <?php $cls = (strpos(strtolower($message),'verif') !== false) ? 'message-success' : 'message-error'; ?>
            <div class="message <?php echo $cls; ?>"><?php echo htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
        <?php endif; ?>

        <form method="POST" class="login-form" novalidate>
            <label for="verify_otp">Enter Code</label>
            <input id="verify_otp" name="verify_otp" type="text" inputmode="numeric" pattern="\d*" placeholder="e.g. 123456" maxlength="6" required>

            <button type="submit" class="btn btn-primary">Verify</button>
        </form>

        <div class="secondary-actions">
            <a class="btn btn-outline" href="#">Resend OTP</a>
            <a class="btn btn-outline" href="login.php">Back to Login</a>
        </div>

        <footer class="card-footer">If you don't receive the code, check your phone number or contact support.</footer>
    </section>
</main>

</body>
</html>

