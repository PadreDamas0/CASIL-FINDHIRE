<?php
require '../core/dbConfig.php';
require '../core/functions.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


checkLogin('Applicant');


$applicant_id = $_SESSION['user_id'];


$hr_id = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];


    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
    if ($stmt->execute([$applicant_id, $hr_id, $content])) {
        echo "<p>Message sent successfully!</p>";
    } else {
        echo "<p>Failed to send message!</p>";
    }
}

if ($stmt->execute([$applicant_id, $hr_id, $content])) {
    echo "<p>Message sent successfully!</p>";
} else {
    echo "<p>Failed to send message!</p>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message to HR</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="container">
        <h1>Send a Message to HR</h1>
        <form method="POST">
            <textarea name="content" placeholder="Write your message here..."></textarea>
            <br>
            <button type="submit">Send Message</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
