<?php
require '../core/dbConfig.php';
require '../core/functions.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


checkLogin('Applicant');


$applicant_id = $_SESSION['user_id'];


$hr_id = 1;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $content = $_POST['content'];


    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$applicant_id, $hr_id, $content]);


    echo "<p class='success-message'>Your message has been sent to HR!</p>";
}


$query = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY sent_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$applicant_id, $hr_id, $hr_id, $applicant_id]);
$messages = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .success-message {
            color: green;
            font-weight: bold;
            text-align: center;
        }

        .message {
            background-color: #f9f9f9;
            border-left: 5px solid #4CAF50;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }

        .message h3 {
            margin: 0;
            color: #4CAF50;
            font-size: 16px;
        }

        .message p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }

        .message small {
            color: #888;
            font-size: 12px;
        }

        form {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        textarea {
            width: 80%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
            height: 150px;
            font-size: 14px;
        }

        button {
            width: 30%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 16px;
            margin-top: 20px;
            display: inline-block;
        }

        a:hover {
            color: #45a049;
        }

        .message-container {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Messages</h1>


        <?php if (count($messages) > 0): ?>
            <div class="message-container">
                <?php foreach ($messages as $message): ?>
                    <div class="message">
                        <h3>From: <?php echo htmlspecialchars($message['sender_id'] == $applicant_id ? 'You' : 'HR'); ?></h3>
                        <p><?php echo htmlspecialchars($message['content']); ?></p>
                        <p><small>Sent at: <?php echo htmlspecialchars($message['sent_at']); ?></small></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No messages available.</p>
        <?php endif; ?>


        <form action="message.php" method="POST">
            <textarea name="content" rows="4" placeholder="Write your message to HR..."></textarea><br>
            <button type="submit">Send Message</button>
        </form>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>

</body>
</html>
