<?php
require 'db.php';

$employees = $pdo->query("SELECT * FROM employees")->fetchAll(PDO::FETCH_ASSOC);
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Voting System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Voting System</h1>
    <form action="vote.php" method="POST">
        <label for="voter">Your Name:</label>
        <select name="voter" required>
            <option value="">Select Your Name</option>
            <?php foreach ($employees as $employee): ?>
                <option value="<?= $employee['id'] ?>"><?= $employee['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="nominee">Nominee:</label>
        <select name="nominee" required>
            <option value="">Select a Nominee</option>
            <?php foreach ($employees as $employee): ?>
                <option value="<?= $employee['id'] ?>"><?= $employee['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="category">Category:</label>
        <select name="category" required>
            <option value="">Select a Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['name'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="comment">Comment:</label>
        <textarea name="comment" rows="4" required></textarea>
        <button type="submit">Submit Vote</button>
        <a href="results.php" class="btn">View Results</a>
    </form>

</div>
</body>
</html>