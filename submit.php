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