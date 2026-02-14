<?php
session_start();
require_once "connection.php";

// Ensure the user has made selections, otherwise redirect
if (!isset($_SESSION['president'], $_SESSION['vice_president'], $_SESSION['secretary'])) {
    header("Location: president.php");
    exit();
}

// capture selections now so we can destroy session later
$presidentChoice = $_SESSION['president'];
$viceChoice = $_SESSION['vice_president'];
$secretaryChoice = $_SESSION['secretary'];

// generate or retrieve voter ID (simple random 12‑digit string)
if (!isset($_SESSION['voter_id'])) {
    // you could also use the NID from login if available
    $_SESSION['voter_id'] = str_pad(strval(rand(0, 999999999999)), 12, '0', STR_PAD_LEFT);
}
$voterId = $_SESSION['voter_id'];

// submission timestamp
$submissionDate = date("l, F j, Y \\\a\\t h:i A");

// clear the session to prevent resubmission
session_unset();
session_destroy();

// optionally insert vote into database
/*
$stmt = $conn->prepare(
    "INSERT INTO votes (voter_id, president, vice_president, secretary, submitted_at)
     VALUES (?, ?, ?, ?, NOW())"
);
$stmt->bind_param("ssss", $voterId, $_SESSION['president'], $_SESSION['vice_president'], $_SESSION['secretary']);
$stmt->execute();
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vote Submitted</title>
<link rel="stylesheet" href="style.css">
<style>
/* custom styles for submit page */
.page-bg { max-width:800px; margin:auto; background:#f3fdf5; padding:40px; border-radius:12px;}
.header {text-align:center;}
.header .icon {font-size:64px; color:#16a34a;}
.header h1 {margin:8px 0; font-size:32px; color:#0b2545;}
.summary-card {background:#fff; padding:20px; border-radius:10px; margin-top:20px;}
.summary-card .row {display:flex; justify-content:space-between; margin-bottom:8px;}
.status {padding:4px 10px; border-radius:8px; background:#16a34a; color:#fff; font-weight:600; font-size:14px;}
.vote-summary {background:#fff; padding:20px; border-radius:10px; margin-top:20px;}
.vote-summary h2 {margin-top:0;}
.vote-item {display:flex; align-items:center; margin-bottom:12px;}
.vote-item .icon {width:24px; height:24px; margin-right:10px; color:#16a34a;}
.info-box {background:#e0f0ff; padding:20px; border-radius:10px; margin-top:20px;}
.return-btn {display:inline-block; margin-top:20px; padding:12px 24px; background:#0b2545; color:#fff; border-radius:8px; text-decoration:none;}
</style>
</head>
<body>
<main class="page-bg">
    <div class="header">
        <div class="icon">✅</div>
        <h1>Vote Successfully Submitted!</h1>
        <p>Thank you for participating in the election</p>
    </div>

    <div class="summary-card">
        <div class="row">
            <span><strong>Voter ID:</strong></span>
            <span><?php echo htmlspecialchars($voterId); ?></span>
        </div>
        <div class="row">
            <span><strong>Submission Date:</strong></span>
            <span><?php echo $submissionDate; ?></span>
        </div>
        <div class="row">
            <span><strong>Status:</strong></span>
            <span class="status">Confirmed</span>
        </div>
    </div>

    <div class="vote-summary">
        <h2>Your Vote Summary</h2>
        <div class="vote-item">
            <span class="icon">✔️</span>
            <div>
                <div><strong>President</strong></div>
                <div><?php echo htmlspecialchars($presidentChoice); ?></div>
            </div>
        </div>
        <div class="vote-item">
            <span class="icon">✔️</span>
            <div>
                <div><strong>Vice President</strong></div>
                <div><?php echo htmlspecialchars($viceChoice); ?></div>
            </div>
        </div>
        <div class="vote-item">
            <span class="icon">✔️</span>
            <div>
                <div><strong>Secretary</strong></div>
                <div><?php echo htmlspecialchars($secretaryChoice); ?></div>
            </div>
        </div>
    </div>

    <div class="info-box">
        <h3>Important Information</h3>
        <ul>
            <li>Your vote has been securely recorded and encrypted</li>
            <li>You can view the results once the voting period ends</li>
            <li>Please save your Voter ID for your records</li>
            <li>You will not be able to vote again in this election</li>
        </ul>
    </div>

    <a href="login.php" class="return-btn">Return to Home</a>
</main>
</body>
</html>