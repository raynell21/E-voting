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
                        "SELECT id, phone FROM students WHERE nid = ? AND phone = ?"
                );
                $stmt->bind_param("ss", $nid, $phone);
                $stmt->execute();
                $result = $stmt->get_result();
                $student = $result->fetch_assoc();

                // 3. Check if student exists
                if (!$student) {
                        $message = "Invalid NID or phone";
                } else {
                    // 4. Check if student has already voted
                    $check_votes = $conn->prepare("SELECT id FROM votes WHERE student_id = ?");
                    $check_votes->bind_param("i", $student['id']);
                    $check_votes->execute();
                    $check_votes->store_result();
                    
                    if ($check_votes->num_rows > 0) {
                        $message = "You have already voted. Each voter can only vote once.";
                    } else {
                        // Student exists and hasn't voted - proceed to OTP
                        $_SESSION['student_id'] = $student['id'];
                        $_SESSION['nid'] = $nid;
                        $_SESSION['phone'] = $student['phone'];
                        header("Location: otp.php");
                        exit();
                    }
                    $check_votes->close();
                }
                $stmt->close();
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
<style>
    /* Comprehensive Responsive Design for Login Page */

    /* Mobile Styles (320px - 767px) */
    @media (max-width: 767px) {
        body {
            padding: 16px !important;
        }
        .login-card {
            padding: 20px !important;
            max-width: 100% !important;
            margin: 0 auto;
            border-radius: 12px !important;
        }
        .brand h1 {
            font-size: 22px !important;
            margin-bottom: 8px !important;
        }
        .brand .subtitle {
            font-size: 14px !important;
            line-height: 1.4 !important;
        }
      /* 🔥 GLOBAL FIX (VERY IMPORTANT) */
.login-form input {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;

    padding: 12px 14px;
    font-size: 16px;
}

/* Prevent overflow issues */
.login-card {
    width: 100%;
    max-width: 420px;
    margin: 0 auto;
    overflow: hidden;
}

/* Buttons consistent */
.btn {
    width: 100%;
    box-sizing: border-box;
}

/* Fix secondary buttons layout */
.secondary-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap; /* prevents breaking layout */
}

.secondary-actions .btn-outline {
    flex: 1;
    text-align: center;
}
        .card-footer {
            text-align: center !important;
            font-size: 12px !important;
            line-height: 1.4 !important;
            margin-top: 16px !important;
        }
        .message {
            font-size: 14px !important;
            padding: 10px 12px !important;
            margin-bottom: 16px !important;
        }
    }

    /* Tablet Styles (768px - 1023px) */
    @media (min-width: 768px) and (max-width: 1023px) {
        body {
            padding: 24px !important;
        }
        .login-card {
            max-width: 480px !important;
            padding: 24px !important;
        }
        .brand h1 {
            font-size: 24px !important;
        }
        .btn {
            padding: 11px 15px !important;
        }
        .secondary-actions .btn-outline {
            padding: 10px 14px !important;
        }
    }

    /* Desktop Styles (1024px+) */
    @media (min-width: 1024px) {
        .login-card {
            max-width: 420px !important;
        }
    }

    /* Large Desktop Styles (1200px+) */
    @media (min-width: 1200px) {
        .login-card {
            max-width: 500px !important;
        }
        .brand h1 {
            font-size: 26px !important;
        }
    }

    /* Extra Large Desktop Styles (1600px+) */
    @media (min-width: 1600px) {
        .login-card {
            max-width: 600px !important;
        }
        .brand h1 {
            font-size: 28px !important;
        }
        .brand .subtitle {
            font-size: 16px !important;
        }
    }

    /* Ultra Wide Desktop Styles (2000px+) */
    @media (min-width: 2000px) {
        .login-card {
            max-width: 700px !important;
        }
        .brand h1 {
            font-size: 32px !important;
        }
        .brand .subtitle {
            font-size: 18px !important;
        }
        .btn {
            padding: 14px 20px !important;
            font-size: 18px !important;
        }
    }

    /* Touch-friendly interactions */
    .btn, .login-form input {
        -webkit-tap-highlight-color: transparent;
        transition: all 0.2s ease;
    }

    .btn:active {
        transform: scale(0.98);
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .login-card {
            border: 2px solid #000 !important;
        }
        .login-form input {
            border: 2px solid #000 !important;
        }
        .btn {
            border: 2px solid #000 !important;
        }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        .btn, .login-form input {
            transition: none !important;
        }
        .btn:active {
            transform: none !important;
        }
    }
</style>
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

<script>
(function () {
    const card = document.querySelector('.login-card');
    if (!card) return;

    function updateScale() {
        const w = window.innerWidth;
        let scale = 1;

        if (w >= 1600) {
            scale = Math.min(1, 1400 / w + 0.1);
            if (scale < 0.8) scale = 0.8;
        } else if (w >= 1200) {
            scale = 1;
        }

        card.style.transform = `scale(${scale})`;
        card.style.transformOrigin = 'top center';
        card.style.transition = 'transform 0.2s ease';
    }

    window.addEventListener('resize', updateScale);
    updateScale();
})();
</script>

</body>
</html>
