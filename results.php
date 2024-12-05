<?php
require 'db.php';

$categoryWinners = $pdo->query("
    SELECT category, nominee_id, COUNT(*) AS vote_count, employees.name 
    FROM votes 
    JOIN employees ON votes.nominee_id = employees.id 
    GROUP BY category, nominee_id
    ORDER BY category, vote_count DESC
")->fetchAll(PDO::FETCH_ASSOC);

$categories = [];
foreach ($categoryWinners as $row) {
    $categories[$row['category']][] = [
        'name' => $row['name'],
        'votes' => $row['vote_count']
    ];
}

$activeVoters = $pdo->query("
    SELECT voter_id, COUNT(*) AS votes_cast, employees.name 
    FROM votes 
    JOIN employees ON votes.voter_id = employees.id 
    GROUP BY voter_id 
    ORDER BY votes_cast DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Voting Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Voting Results</h1>

    <h2>Category Winners</h2>
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category => $winners): ?>
            <h3><?= htmlspecialchars($category) ?></h3>
            <table>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Votes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($winners as $winner): ?>
                        <tr>
                            <td><?= htmlspecialchars($winner['name']) ?></td>
                            <td><?= $winner['votes'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No votes have been cast yet.</p>
    <?php endif; ?>

    <h2>Most Active Voters</h2>
    <?php if (!empty($activeVoters)): ?>
        <table>
            <thead>
                <tr>
                    <th>Voter</th>
                    <th>Votes Cast</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activeVoters as $voter): ?>
                    <tr>
                        <td><?= htmlspecialchars($voter['name']) ?></td>
                        <td><?= $voter['votes_cast'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No voting activity has been recorded yet.</p>
    <?php endif; ?>
    
    <a href="index.php" class="btn">Go Back to Voting</a>
</div>
</body>
</html>