<?php
session_start();
require_once "connection.php";

// Get election results
$results = [];

// Query results for President
$query = $conn->prepare("
    SELECT president as candidate, COUNT(*) as vote_count 
    FROM votes 
    WHERE president IS NOT NULL 
    GROUP BY president 
    ORDER BY vote_count DESC
");
$query->execute();
$result = $query->get_result();
$results['president'] = [];
while ($row = $result->fetch_assoc()) {
    $results['president'][] = $row;
}
$query->close();

// Query results for Vice President
$query = $conn->prepare("
    SELECT vice_president as candidate, COUNT(*) as vote_count 
    FROM votes 
    WHERE vice_president IS NOT NULL 
    GROUP BY vice_president 
    ORDER BY vote_count DESC
");
$query->execute();
$result = $query->get_result();
$results['vice_president'] = [];
while ($row = $result->fetch_assoc()) {
    $results['vice_president'][] = $row;
}
$query->close();

// Query results for Secretary
$query = $conn->prepare("
    SELECT secretary as candidate, COUNT(*) as vote_count 
    FROM votes 
    WHERE secretary IS NOT NULL 
    GROUP BY secretary 
    ORDER BY vote_count DESC
");
$query->execute();
$result = $query->get_result();
$results['secretary'] = [];
while ($row = $result->fetch_assoc()) {
    $results['secretary'][] = $row;
}
$query->close();

// Get total votes
$total_votes_query = $conn->prepare("SELECT COUNT(*) as total FROM votes");
$total_votes_query->execute();
$total_votes_result = $total_votes_query->get_result();
$total_votes = $total_votes_result->fetch_assoc()['total'];
$total_votes_query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Results</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .results-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .results-header {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .results-header h1 {
            margin: 0;
            color: #333;
            font-size: 2.5em;
        }
        .results-header .subtitle {
            color: #666;
            margin-top: 10px;
            font-size: 1.1em;
        }
        .results-header .vote-count {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            font-size: 1.1em;
        }
        .position-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .position-section h2 {
            color: #667eea;
            border-bottom: 2px solid #667eea;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .candidate-result {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .candidate-result.winner {
            background: #e8f5e9;
            border-left-color: #4caf50;
        }
        .candidate-result.runner-up {
            background: #fff3e0;
            border-left-color: #ff9800;
        }
        .candidate-rank {
            font-size: 2em;
            font-weight: bold;
            margin-right: 20px;
            color: #667eea;
            min-width: 50px;
        }
        .candidate-result.winner .candidate-rank {
            color: #4caf50;
        }
        .candidate-result.runner-up .candidate-rank {
            color: #ff9800;
        }
        .candidate-info {
            flex-grow: 1;
        }
        .candidate-name {
            font-size: 1.1em;
            font-weight: 600;
            color: #333;
        }
        .candidate-votes {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }
        .vote-bar {
            background: #e0e0e0;
            height: 8px;
            border-radius: 4px;
            margin-top: 8px;
            overflow: hidden;
        }
        .vote-bar-fill {
            height: 100%;
            background: #667eea;
            transition: width 0.3s ease;
        }
        .candidate-result.winner .vote-bar-fill {
            background: #4caf50;
        }
        .candidate-result.runner-up .vote-bar-fill {
            background: #ff9800;
        }
        .no-results {
            text-align: center;
            padding: 20px;
            color: #999;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
            margin-left: 10px;
        }
        .badge.winner {
            background: #4caf50;
            color: white;
        }
        .badge.runner-up {
            background: #ff9800;
            color: white;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: white;
        }
        .footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>

<div class="results-container">
    <div class="results-header">
        <h1>🗳️ Election Results</h1>
        <p class="subtitle">Final Election Results</p>
        <div class="vote-count">
            Total Votes Cast: <strong><?php echo $total_votes; ?></strong>
        </div>
    </div>

    <!-- President Results -->
    <div class="position-section">
        <h2>President Election Results</h2>
        <?php if (!empty($results['president'])): ?>
            <?php foreach ($results['president'] as $index => $candidate): ?>
                <?php 
                    $percentage = $total_votes > 0 ? ($candidate['vote_count'] / $total_votes) * 100 : 0;
                    $class = $index === 0 ? 'winner' : ($index === 1 ? 'runner-up' : '');
                ?>
                <div class="candidate-result <?php echo $class; ?>">
                    <div class="candidate-rank"><?php echo $index + 1; ?></div>
                    <div class="candidate-info">
                        <div class="candidate-name">
                            <?php echo htmlspecialchars($candidate['candidate'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                            <?php if ($class === 'winner'): ?>
                                <span class="badge winner">WINNER</span>
                            <?php elseif ($class === 'runner-up'): ?>
                                <span class="badge runner-up">RUNNER-UP</span>
                            <?php endif; ?>
                        </div>
                        <div class="candidate-votes">
                            <?php echo $candidate['vote_count']; ?> votes (<?php echo number_format($percentage, 1); ?>%)
                        </div>
                        <div class="vote-bar">
                            <div class="vote-bar-fill" style="width: <?php echo $percentage; ?>%"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results">No votes recorded yet.</div>
        <?php endif; ?>
    </div>

    <!-- Vice President Results -->
    <div class="position-section">
        <h2>Vice President Election Results</h2>
        <?php if (!empty($results['vice_president'])): ?>
            <?php foreach ($results['vice_president'] as $index => $candidate): ?>
                <?php 
                    $percentage = $total_votes > 0 ? ($candidate['vote_count'] / $total_votes) * 100 : 0;
                    $class = $index === 0 ? 'winner' : ($index === 1 ? 'runner-up' : '');
                ?>
                <div class="candidate-result <?php echo $class; ?>">
                    <div class="candidate-rank"><?php echo $index + 1; ?></div>
                    <div class="candidate-info">
                        <div class="candidate-name">
                            <?php echo htmlspecialchars($candidate['candidate'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                            <?php if ($class === 'winner'): ?>
                                <span class="badge winner">WINNER</span>
                            <?php elseif ($class === 'runner-up'): ?>
                                <span class="badge runner-up">RUNNER-UP</span>
                            <?php endif; ?>
                        </div>
                        <div class="candidate-votes">
                            <?php echo $candidate['vote_count']; ?> votes (<?php echo number_format($percentage, 1); ?>%)
                        </div>
                        <div class="vote-bar">
                            <div class="vote-bar-fill" style="width: <?php echo $percentage; ?>%"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results">No votes recorded yet.</div>
        <?php endif; ?>
    </div>

    <!-- Secretary Results -->
    <div class="position-section">
        <h2>Secretary Election Results</h2>
        <?php if (!empty($results['secretary'])): ?>
            <?php foreach ($results['secretary'] as $index => $candidate): ?>
                <?php 
                    $percentage = $total_votes > 0 ? ($candidate['vote_count'] / $total_votes) * 100 : 0;
                    $class = $index === 0 ? 'winner' : ($index === 1 ? 'runner-up' : '');
                ?>
                <div class="candidate-result <?php echo $class; ?>">
                    <div class="candidate-rank"><?php echo $index + 1; ?></div>
                    <div class="candidate-info">
                        <div class="candidate-name">
                            <?php echo htmlspecialchars($candidate['candidate'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                            <?php if ($class === 'winner'): ?>
                                <span class="badge winner">WINNER</span>
                            <?php elseif ($class === 'runner-up'): ?>
                                <span class="badge runner-up">RUNNER-UP</span>
                            <?php endif; ?>
                        </div>
                        <div class="candidate-votes">
                            <?php echo $candidate['vote_count']; ?> votes (<?php echo number_format($percentage, 1); ?>%)
                        </div>
                        <div class="vote-bar">
                            <div class="vote-bar-fill" style="width: <?php echo $percentage; ?>%"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results">No votes recorded yet.</div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>© 2026 University Election System | Election Management Office</p>
        <p>
            <a href="login.php">Back to Login</a>
        </p>
    </div>
</div>

</body>
</html>
