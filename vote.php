<?php
require 'db.php';

$message = '';
$messageClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voter = $_POST['voter'];
    $nominee = $_POST['nominee'];
    $category = $_POST['category'];
    $comment = trim($_POST['comment']);

    if ($voter == $nominee) {
        $message = "Error: You cannot vote for yourself!";
        $messageClass = 'error';
    } elseif (empty($comment)) {
        $message = "Error: Comment is required!";
        $messageClass = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO votes (voter_id, nominee_id, category, comment) VALUES (?, ?, ?, ?)");
            $stmt->execute([$voter, $nominee, $category, $comment]);
            $message = "Vote successfully submitted!";
            $messageClass = 'success';
        } catch (Exception $e) {
            $message = "Error: Could not submit your vote.";
            $messageClass = 'error';
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Vote Submission</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Vote Submission</h1>
    <?php if (!empty($message)): ?>
        <p class="<?= htmlspecialchars($messageClass) ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <a href="index.php" class="btn">Go Back to Voting</a>
</div>
</body>
</html>