<?php
session_start();
require_once "connection.php";

// Ensure the user has made selections, otherwise redirect
if (!isset($_SESSION['president'], $_SESSION['vice_president'], $_SESSION['secretary'], $_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Check if user hasn't already voted
$student_id = $_SESSION['student_id'];
$check_votes = $conn->prepare("SELECT id FROM votes WHERE student_id = ?");
$check_votes->bind_param("i", $student_id);
$check_votes->execute();
$check_votes->store_result();

if ($check_votes->num_rows > 0) {
    // User has already voted
    $check_votes->close();
    session_unset();
    session_destroy();
    $error_msg = "You have already voted. Each voter can only vote once.";
} else {
    // capture selections
    $presidentChoice = $_SESSION['president'];
    $viceChoice = $_SESSION['vice_president'];
    $secretaryChoice = $_SESSION['secretary'];
    $nid = $_SESSION['nid'];

    // Insert vote into database
    $insert = $conn->prepare(
        "INSERT INTO votes (student_id, nid, president, vice_president, secretary) 
         VALUES (?, ?, ?, ?, ?)"
    );
    
    if ($insert === false) {
        $error_msg = "Database error: " . $conn->error;
    } else {
        $insert->bind_param("issss", $student_id, $nid, $presidentChoice, $viceChoice, $secretaryChoice);
        
        if ($insert->execute()) {
            $check_votes->close();
            // Vote recorded successfully
            // submission timestamp
            $submissionDate = date("l, F j, Y \\\a\\t h:i A");
            $voterId = str_pad(strval($student_id), 12, '0', STR_PAD_LEFT);
            
            // Clear the session to prevent resubmission
            session_unset();
            session_destroy();
            $vote_success = true;
        } else {
            $error_msg = "Error recording vote: " . $insert->error;
        }
        $insert->close();
    }
    $check_votes->close();
}
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
.confirmation-box { border: 2px solid #00a651; padding: 20px; border-radius: 8px; margin: 20px 0; background: #f0f9f5; }
.error-box { border: 2px solid #d32f2f; padding: 20px; border-radius: 8px; margin: 20px 0; background: #ffebee; }
.confirmation-box h2 { color: #00a651; }
.error-box h2 { color: #d32f2f; }
.btn { display: inline-block; margin: 10px 5px; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
.btn-primary { background: #007bff; color: white; }
.btn-primary:hover { background: #0056b3; }
</style>
</head>
<body>

<main class="page-bg">
    <section class="header">
        <h1>E-Voting System</h1>
    </section>

    <?php if (isset($error_msg)): ?>
        <div class="error-box">
            <h2>⚠️ Vote Not Recorded</h2>
            <p><?php echo htmlspecialchars($error_msg, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
            <p><a href="login.php" class="btn btn-primary">Return to Login</a></p>
        </div>
    <?php elseif (isset($vote_success)): ?>
        <div class="confirmation-box">
            <h2>✅ Vote Successfully Recorded</h2>
            <p><strong>Receipt Number:</strong> <?php echo htmlspecialchars($voterId, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
            <p><strong>Submitted:</strong> <?php echo $submissionDate; ?></p>
            
            <h3>Your Selections:</h3>
            <ul>
                <li><strong>President:</strong> <?php echo htmlspecialchars($presidentChoice, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
                <li><strong>Vice President:</strong> <?php echo htmlspecialchars($viceChoice, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
                <li><strong>Secretary:</strong> <?php echo htmlspecialchars($secretaryChoice, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
            </ul>

            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                Your vote is anonymous and cannot be changed. Thank you for participating in this election.
            </p>

            <p><a href="login.php" class="btn btn-primary">Exit</a></p>
        </div>
    <?php else: ?>
        <p>Processing your vote...</p>
    <?php endif; ?>
</main>

</body>
</html>
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